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
    <form onSubmit={handleSubmit}>
      <h2>Add New Book</h2>
      <div>
        <label>Title:</label>
        <input
          type="text"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          required
        />
      </div>
      <div>
        <label>Description:</label>
        <textarea
          value={description}
          onChange={(e) => setDescription(e.target.value)}
          required
        />
      </div>
      <div>
        <label>Cover URL:</label>
        <input
          type="text"
          value={cover}
          onChange={(e) => setCover(e.target.value)}
        />
      </div>
      <button type="submit">Add Book</button>
    </form>
  );
};

export default AddBookForm;