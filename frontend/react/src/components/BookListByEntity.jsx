import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';

const entityConfig = {
  tags: {
    api: id => `/api/tags/${id}`,
    label: 'Tag'
  },
  genres: {
    api: id => `/api/genres/${id}`,
    label: 'Genre'
  },
  authors: {
    api: id => `/api/authors/${id}`,
    label: 'Author'
  }
};

const BookListByEntity = () => {
  const { entityType, id } = useParams();
  const [books, setBooks] = useState([]);
  const [error, setError] = useState('');
  const config = entityConfig[entityType];

  useEffect(() => {
    if (!config) return;
    const fetchBooks = async () => {
      try {
        const res = await fetch(config.api(id));
        if (!res.ok) {
          setError('Failed to load books.');
          setBooks([]);
          return;
        }
        const data = await res.json();
        setBooks(data);
        setError('');
      } catch {
        setError('Failed to load books.');
        setBooks([]);
      }
    };
    fetchBooks();
  }, [entityType, id]);

  if (!config) return <div>Unknown entity type.</div>;
  if (error) return <div>{error}</div>;

  return (
    <div>
      <h2>Books for {config.label} #{id}</h2>
      <ul>
        {books.length === 0 && <li>No books found.</li>}
        {books.map(book => (
          <li key={book.id}>
            <Link to={`/books/${book.id}`}>
              {book.title}
            </Link>
            {book.author && <> by {book.author}</>}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default BookListByEntity;