import React from 'react';
import { Link } from 'react-router-dom';

function parseJwt(token) {
  if (!token) return null;
  try {
    return JSON.parse(atob(token.split('.')[1]));
  } catch {
    return null;
  }
}

const Header = ({ token, onLogout }) => {
  const user = parseJwt(token);
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
          <Link to="/entities?type=genre" className="nav-link">
            <img src="/images/header/box.svg" alt="" className="logo" />
            Genres
          </Link>
          <Link to="/entities?type=tag" className="nav-link">
            <img src="/images/header/tag.svg" alt="" className="logo" />
            Tags
          </Link>
        </nav>
        <form className="search-bar desktop-search-bar">
          <input type="text" placeholder="Search by title or author" />
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
              {user?.role === 'admin' && (
                <Link to="/administration" className="nav-link">
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