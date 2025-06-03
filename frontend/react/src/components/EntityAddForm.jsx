import React, { useState } from 'react';

const entityConfig = {
  authors: {
    api: '/api/authors',
    field: 'author',
    placeholder: 'Author name',
    button: 'Add Author'
  },
  genres: {
    api: '/api/genres',
    field: 'genre',
    placeholder: 'Genre name',
    button: 'Add Genre'
  },
  tags: {
    api: '/api/tags',
    field: 'tag',
    placeholder: 'Tag name',
    button: 'Add Tag'
  }
};

const EntityAddForm = ({ token, entityType }) => {
  const config = entityConfig[entityType];
  const [value, setValue] = useState('');
  const [message, setMessage] = useState('');

  if (!config) return null;

  const handleSubmit = async e => {
    e.preventDefault();
    setMessage('');
    const res = await fetch(config.api, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify({ [config.field]: value }),
    });
    const data = await res.json();
    if (res.ok) {
      setMessage(`${config.button.replace('Add ', '')} added!`);
      setValue('');
    } else {
      setMessage(data.error || 'Error');
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <input
        value={value}
        onChange={e => setValue(e.target.value)}
        placeholder={config.placeholder}
        required
      />
      <button type="submit">{config.button}</button>
      {message && <div>{message}</div>}
    </form>
  );
};

export default EntityAddForm;