import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';

const BookDetails = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [book, setBook] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(false);

  const fetchBook = async () => {
    try {
      const response = await fetch(`/api/books/${id}`);
      if (response.status === 404) {
        setError(true);
        return;
      }
      const data = await response.json();
      setBook(data);
    } catch (error) {
      console.error('Error fetching book:', error);
      setError(true);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchBook();
  }, [id]);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Book not found</p>;

  return (
    <div>
      <h1>Book Details</h1>
      <table border="1" cellPadding="10" style={{ width: '50%', margin: '0 auto', textAlign: 'left' }}>
        <tbody>
          <tr>
            <th>ID</th>
            <td>{book.id}</td>
          </tr>
          <tr>
            <th>Title</th>
            <td>{book.title}</td>
          </tr>
          <tr>
            <th>Description</th>
            <td>{book.description}</td>
          </tr>
          {book.cover && (
            <tr>
              <th>Cover</th>
              <td>
                <img src={book.cover} alt={book.title} style={{ maxWidth: '100%' }} />
              </td>
            </tr>
          )}
        </tbody>
      </table>
      <button onClick={() => navigate('/')} style={{ marginTop: '20px' }}>Back to List</button>
    </div>
  );
};

export default BookDetails;