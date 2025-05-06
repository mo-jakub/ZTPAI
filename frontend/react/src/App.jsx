import React, { useState } from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import BookList from './components/BookList';
import BookDetails from './components/BookDetails';
import AddBookForm from './components/AddBookForm';
import RegisterForm from './components/RegisterForm';
import LoginForm from './components/LoginForm';

const App = () => {
  const [token, setToken] = useState('');

  return (
    <Router>
      <div>
        <LoginForm onToken={setToken} />
        {token && (
          <div>
            <h3>JWT Token:</h3>
            <textarea value={token} readOnly style={{ width: '100%' }} rows={3} />
          </div>
        )}
        {/* Linki do stron */}
        <nav style={{ margin: '20px 0' }}>
          <Link to="/register" style={{ marginRight: 20 }}>Rejestracja</Link>
          <Link to="/books" style={{ marginRight: 20 }}>Lista książek</Link>
          <Link to="/add-book">Dodaj książkę</Link>
        </nav>
        <Routes>
          <Route path="/register" element={<RegisterForm />} />
          <Route path="/books" element={<BookList token={token} />} />
          <Route path="/add-book" element={<AddBookForm token={token} />} />
          <Route path="/books/:id" element={<BookDetails token={token} />} />
        </Routes>
      </div>
    </Router>
  );
};

export default App;