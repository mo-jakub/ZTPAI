import React, { useEffect, useState } from 'react';
import { useLocation, Link } from 'react-router-dom';

function useQuery() {
  return new URLSearchParams(useLocation().search);
}

function isAdmin(token) {
  if (!token) return false;
  try {
    const payload = JSON.parse(atob(token.split('.')[1]));
    return payload.roles && payload.roles.includes('ROLE_ADMIN');
  } catch {
    return false;
  }
}

const BookList = ({ token }) => {
  const [books, setBooks] = useState([]);
  const query = useQuery();
  const search = query.get('search');
  const admin = isAdmin(token);
  const location = useLocation();

  const showDelete = admin && location.pathname.includes('/admin');

  useEffect(() => {
    let url = '/api/books';
    if (search) {
      url += `?search=${encodeURIComponent(search)}`;
    }
    fetch(url, {
      headers: token ? { Authorization: `Bearer ${token}` } : {}
    })
      .then(res => res.json())
      .then(setBooks)
      .catch(() => setBooks([]));
  }, [search, token]);

  const handleDelete = async id => {
    if (!window.confirm('Are you sure you want to delete this book?')) return;
    await fetch(`/api/books/${id}`, {
      method: 'DELETE',
      headers: { Authorization: `Bearer ${token}` }
    });
    setBooks(books.filter(book => book.id !== id));
  };

  return (
    <div>
      <h2>Books</h2>
      <ul>
        {books.length === 0 && <li>No books found.</li>}
        {books.map(book => (
          <li key={book.id}>
            <Link to={`/books/${book.id}`} className='nav-link' style={{ justifyContent: 'center' }}>{book.title}</Link>
            {showDelete && (
              <button
                onClick={() => handleDelete(book.id)}
                style={{ marginLeft: 8 }}
              >
                Delete
              </button>
            )}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default BookList;