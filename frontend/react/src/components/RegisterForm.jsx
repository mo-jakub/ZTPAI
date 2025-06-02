import React, { useState } from 'react';

const RegisterForm = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [msg, setMsg] = useState('');

  const handleRegister = async (e) => {
    e.preventDefault();
    setMsg('');
    try {
      const response = await fetch('/api/register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
      });
      const data = await response.json();
      if (response.ok) {
        setMsg('Registration successful!');
      } else {
        setMsg(data.message || data.error || 'Registration failed');
      }
    } catch (err) {
      setMsg('Error: ' + err.message);
    }
  };

  return (
    <main class="page">
      <div class="info">
        <img src="/images/on-page-logo.svg" alt="Logo" class="on-page-logo"/>
        <h2>Join us now.</h2>
        <p>So that you can share your thoughts</p>
        <p>regarding all the books</p>
        <p>and discuss them with others.</p>
        <p>It's free and easy.</p>
      </div>
      <div class="auth-form">
        <form onSubmit={handleRegister} style={{ marginBottom: 30 }}>
          <h2>Create an Account</h2>
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
          <button type="submit">Sign Up</button>
          <div>{msg}</div>
        </form>
      </div>
    </main>
  );
};

export default RegisterForm;