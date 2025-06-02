import React, { useState } from 'react';

const LoginForm = ({ onToken }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [msg, setMsg] = useState('');

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
        onToken(data.token);
      } else {
        setMsg(data.message || data.error || 'Login failed');
      }
    } catch (err) {
      setMsg('Error: ' + err.message);
    }
  };

  return (
    <main class="page">
      <div class="info">
        <img src="/images/on-page-logo.svg" alt="Logo" class="on-page-logo"/>
        <h2>We're glad to have you back.</h2>
      </div>
      <div class="auth-form">
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