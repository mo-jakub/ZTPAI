import React, { useState } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import BookList from './components/BookList';
import BookDetails from './components/BookDetails';
import AddBookForm from './components/AddBookForm';
import RegisterForm from './components/RegisterForm';
import LoginForm from './components/LoginForm';

const App = () => {
  const [token, setToken] = useState('');

  return (
    <div>
      <RegisterForm />
      <LoginForm onToken={setToken} />
      {token && (
        <div>
          <h3>JWT Token:</h3>
          <textarea value={token} readOnly style={{ width: '100%' }} rows={3} />
        </div>
      )}
    </div>
  );
};

export default App;