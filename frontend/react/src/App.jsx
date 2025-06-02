import React, { useState } from 'react';
import { BrowserRouter as Router, Routes, Route, Link, useNavigate } from 'react-router-dom';
import Header from './components/Header';
import Footer from './components/Footer';
import BookList from './components/BookList';
import BookDetails from './components/BookDetails';
import AddBookForm from './components/AddBookForm';
import RegisterForm from './components/RegisterForm';
import LoginForm from './components/LoginForm';

const App = () => {
  const [token, setToken] = useState('');

  const handleLogout = () => {
    setToken('');
  };

  return (
    <Router>
      <Header token={token} onLogout={handleLogout} />
      <div className="main-content">
        <Routes>
          <Route path="/login" element={<LoginForm onToken={setToken} />} />
          <Route path="/register" element={<RegisterForm />} />
          <Route path="/books" element={<BookList token={token} />} />
          <Route path="/add-book" element={<AddBookForm token={token} />} />
          <Route path="/books/:id" element={<BookDetails token={token} />} />
        </Routes>
      </div>
      <Footer />
    </Router>
  );
};

export default App;