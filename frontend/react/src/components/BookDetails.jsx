import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

const BookDetails = () => {
  const { id } = useParams();
  const [book, setBook] = useState(null);
  const [loading, setLoading] = useState(true);

  const fetchBook = async () => {
    try {
      const response = await fetch(`http://localhost:8000/api/books/${id}`);
      const data = await response.json();
      setBook(data);
    } catch (error) {
      console.error('Error fetching book:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchBook();
  }, [id]);

  if (loading) return <p>Loading...</p>;
  if (!book) return <p>Book not found</p>;

  return (
    <div>
      <h1>{book.title}</h1>
      <p>{book.description}</p>
      {book.cover && <img src={book.cover} alt={book.title} />}
    </div>
  );
};

export default BookDetails;