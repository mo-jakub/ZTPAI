import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Link, useNavigate } from 'react-router-dom';
import Header from './components/Header';
import Footer from './components/Footer';
import BookList from './components/BookList';
import BookDetails from './components/BookDetails';
import AddBookForm from './components/AddBookForm';
import RegisterForm from './components/RegisterForm';
import LoginForm from './components/LoginForm';
import AdminPanel from './components/AdminPanel';
import EntityList from './components/EntityList';
import LandingPage from './components/LandingPage';
import BookListByEntity from './components/BookListByEntity';

const App = () => {
  const [token, setToken] = useState('');

  const handleLogout = () => {
    setToken('');
    document.cookie = 'jwt_token' + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
  };

  function getCookie(name) {
    return document.cookie.split('; ').find(row => row.startsWith(name + '='))?.split('=')[1];
  }

  useEffect(() => {
    const token = getCookie('jwt_token');
    if (token) setToken(token);
  }, []);

  return (
    <Router>
      <Header token={token} onLogout={handleLogout} />
      <div className="main-content">
        <Routes>
          <Route path="/" element={<LandingPage />} />
          <Route path="/login" element={<LoginForm onToken={setToken} />} />
          <Route path="/register" element={<RegisterForm />} />
          <Route path="/books" element={<BookList token={token} />} />
          <Route path="/add-book" element={<AddBookForm token={token} />} />
          <Route path="/books/:id" element={<BookDetails token={token} />} />
          <Route path="/admin" element={<AdminPanel token={token} />} />
          <Route path="/tags" element={<EntityList token={token} />} />
          <Route path="/genres" element={<EntityList token={token} />} />
          <Route path="/authors" element={<EntityList token={token} />} />
          <Route path="/:entityType/:id" element={<BookListByEntity />} />
        </Routes>
      </div>
      <Footer />
    </Router>
  );
};

export default App;