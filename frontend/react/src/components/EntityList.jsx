import React, { useEffect, useState } from 'react';
import { Link, useLocation } from 'react-router-dom';

function isAdmin(token) {
  if (!token) return false;
  try {
    const payload = JSON.parse(atob(token.split('.')[1]));
    return payload.roles && payload.roles.includes('ROLE_ADMIN');
  } catch {
    return false;
  }
}

// Map entity type to API endpoint and display field
const entityConfig = {
  tags: {
    api: '/api/tags',
    display: 'tag',
    link: id => `/tags/${id}`
  },
  genres: {
    api: '/api/genres',
    display: 'genre',
    link: id => `/genres/${id}`
  },
  authors: {
    api: '/api/authors',
    display: 'author',
    link: id => `/authors/${id}`
  }
};

const EntityList = ({ token, entityType: propEntityType }) => {
  const [entities, setEntities] = useState([]);
  const admin = isAdmin(token);
  const location = useLocation();

  // Use prop if provided, otherwise infer from URL
  const entityType = propEntityType ||
    Object.keys(entityConfig).find(type => location.pathname.includes(type));

  const config = entityConfig[entityType];

  const showDelete = admin && location.pathname.includes('/admin');

  useEffect(() => {
    if (!config) return;
    const fetchEntities = async () => {
      const res = await fetch(config.api, {
        headers: token ? { Authorization: `Bearer ${token}` } : {}
      });
      if (!res.ok) {
        setEntities([]);
        return;
      }
      const data = await res.json();
      setEntities(data);
    };
    fetchEntities();
  }, [token, entityType]);

  const handleDelete = async id => {
    await fetch(`${config.api}/${id}`, {
      method: 'DELETE',
      headers: { Authorization: `Bearer ${token}` }
    });
    setEntities(entities.filter(e => e.id !== id));
  };

  if (!config) return <div>Unknown entity type.</div>;

  return (
    <ul>
      {entities.map(e => (
        <li key={e.id} style={{ display: 'flex', justifyContent: 'center', flexDirection: 'column' }}>
          <Link to={config.link(e.id)} className='nav-link' style={{ justifyContent: 'center' }}>
            {e[config.display]}
          </Link>
          {showDelete && (
            <button onClick={() => handleDelete(e.id)} style={{ marginLeft: 8 }}>Delete</button>
          )}
        </li>
      ))}
    </ul>
  );
};

export default EntityList;