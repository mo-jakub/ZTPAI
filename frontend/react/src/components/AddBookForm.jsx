import React, { useState } from 'react';

const AddBookForm = () => {
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [cover, setCover] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await fetch('http://localhost:8000/api/books', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title, description, cover }),
      });
      if (response.ok) {
        alert('Book added successfully!');
        setTitle('');
        setDescription('');
        setCover('');
      } else {
        alert('Failed to add book');
      }
    } catch (error) {
      console.error('Error adding book:', error);
    }
  };

  return (
    <form onSubmit={handleSubmit} style={{ maxWidth: '500px', margin: '0 auto' }}>
      <h2 style={{ textAlign: 'center', marginBottom: '20px' }}>Add New Book</h2>
      <table style={{ width: '100%', borderCollapse: 'collapse' }}>
        <tbody>
          <tr>
            <td style={{ padding: '10px', fontWeight: 'bold', width: '30%' }}>Title:</td>
            <td style={{ padding: '10px' }}>
              <input
                type="text"
                value={title}
                onChange={(e) => setTitle(e.target.value)}
                required
                style={{ width: '100%', padding: '8px' }}
              />
            </td>
          </tr>
          <tr>
            <td style={{ padding: '10px', fontWeight: 'bold' }}>Description:</td>
            <td style={{ padding: '10px' }}>
              <textarea
                value={description}
                onChange={(e) => setDescription(e.target.value)}
                required
                style={{ width: '100%', padding: '8px' }}
              />
            </td>
          </tr>
          <tr>
            <td style={{ padding: '10px', fontWeight: 'bold' }}>Cover URL:</td>
            <td style={{ padding: '10px' }}>
              <input
                type="text"
                value={cover}
                onChange={(e) => setCover(e.target.value)}
                style={{ width: '100%', padding: '8px' }}
              />
            </td>
          </tr>
        </tbody>
      </table>
      <button
        type="submit"
        style={{
          marginTop: '20px',
          padding: '10px 20px',
          backgroundColor: '#007BFF',
          color: '#fff',
          border: 'none',
          cursor: 'pointer',
          display: 'block',
          marginLeft: 'auto',
          marginRight: 'auto',
        }}
      >
        Add Book
      </button>
    </form>
  );
};

export default AddBookForm;