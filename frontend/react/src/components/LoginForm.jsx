import React, { useState } from 'react';

const LoginForm = ({ onToken }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [msg, setMsg] = useState('');

  const setCookie = (name, value, days) => {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
  };

  const handleLogin = async (e) => {
    e.preventDefault();
    setMsg('');
    try {
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
      });
      const data = await response.json();
      if (response.ok && data.token) {
        setMsg('Login successful!');
        setCookie('jwt_token', data.token, 0.02); // 30 minutes
        onToken(data.token);
      } else {
        setMsg(data.message || data.error || 'Login failed');
      }
    } catch (err) {
      setMsg('Error: ' + err.message);
    }
  };

  return (
    <main className="page">
      <div className="info">
        <img src="/images/on-page-logo.svg" alt="Logo" className="on-page-logo"/>
        <h2>We're glad to have you back.</h2>
      </div>
      <div className="auth-form">
        <form onSubmit={handleLogin}>
          <h2>Log Into an Existing Account</h2>
          <input
            type="email"
            placeholder="Email"
            value={email}
            required
            onChange={e => setEmail(e.target.value)}
            style={{ margin: 5 }}
          />
          <input
            type="password"
            placeholder="Password"
            value={password}
            required
            onChange={e => setPassword(e.target.value)}
            style={{ margin: 5 }}
          />
          <button type="submit">Login</button>
          <div>{msg}</div>
        </form>
      </div>
    </main>
  );
};

export default LoginForm;