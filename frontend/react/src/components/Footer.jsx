import React from 'react';
import { Link } from 'react-router-dom';

const Footer = () => (
  <footer>
    <div className="container">
      <div className="nav-wrapper">
        <Link to="/info?page=about" className="nav-link">
          <button>About Us</button>
        </Link>
        <Link to="/info?page=contact" className="nav-link">
          <button>Contact</button>
        </Link>
      </div>
      <div className="nav-wrapper">
        <a href="#" className="nav-link">
          <img src="/images/footer/twitter.svg" alt="Twitter" className="logo" />
        </a>
        <a href="#" className="nav-link">
          <img src="/images/footer/facebook.svg" alt="Facebook" className="logo" />
        </a>
        <a href="#" className="nav-link">
          <img src="/images/footer/discord.svg" alt="Discord" className="logo" />
        </a>
      </div>
    </div>
  </footer>
);

export default Footer;