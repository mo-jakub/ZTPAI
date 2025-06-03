import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';

function isAdmin(token) {
  if (!token) return false;
  try {
    const payload = JSON.parse(atob(token.split('.')[1]));
    return payload.roles && payload.roles.includes('ROLE_ADMIN');
  } catch {
    return false;
  }
}

function parseJwt(token) {
  if (!token) return null;
  try {
    return JSON.parse(atob(token.split('.')[1]));
  } catch (e) {
    return null;
  }
}

const Header = ({ token, onLogout }) => {
  const user = parseJwt(token);
  const [searchTerm, setSearchTerm] = useState('');
  const navigate = useNavigate();

  const handleSearch = e => {
    e.preventDefault();
    if (searchTerm.trim()) {
      navigate(`/books?search=${encodeURIComponent(searchTerm.trim())}`);
    }
  };

  return (
    <header>
      <div className="container">
        <Link to="/" className="logo-link">
          <img src="/images/logo.svg" alt="Logo" className="logo" />
          Power of Knowledge
        </Link>
        <nav className="nav-wrapper">
          <Link to="/" className="nav-link">
            <img src="/images/header/home.svg" alt="" className="logo" />
            Home
          </Link>
          <Link to="/genres" className="nav-link">
            <img src="/images/header/box.svg" alt="" className="logo" />
            Genres
          </Link>
          <Link to="/tags" className="nav-link">
            <img src="/images/header/tag.svg" alt="" className="logo" />
            Tags
          </Link>
        </nav>
        <form className="search-bar desktop-search-bar" onSubmit={handleSearch}>
          <input
            type="text"
            placeholder="Search by title or author"
            value={searchTerm}
            onChange={e => setSearchTerm(e.target.value)}
          />
        </form>
        <nav className="nav-wrapper auth">
          {token ? (
            <>
              <button onClick={onLogout} className="nav-link" style={{ background: 'none', border: 'none', padding: 0 }}>
                <img src="/images/header/logout.svg" alt="" className="logo" />
                Logout
              </button>
              <Link to={`/user/${user?.userId || ''}`} className="nav-link">
                <img src="/images/user.svg" alt="" className="logo" />
                {user?.username || 'User'}
              </Link>
              {isAdmin(token) && (
                <Link to="/admin" className="nav-link">
                  <img src="/images/header/admin.svg" alt="" className="logo" />
                  Administration
                </Link>
              )}
            </>
          ) : (
            <>
              <Link to="/login" className="nav-link">
                <img src="/images/header/login.svg" alt="" className="logo" />
                Login
              </Link>
              <Link to="/register" className="nav-link">
                <img src="/images/header/signup.svg" alt="" className="logo" />
                Sign Up
              </Link>
            </>
          )}
        </nav>
      </div>
    </header>
  );
};

export default Header;