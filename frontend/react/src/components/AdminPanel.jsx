import React from 'react';
import AddBookForm from './AddBookForm';
import EntityAddForm from './EntityAddForm';
import EntityList from './EntityList';
import BookList from './BookList';

function isAdmin(token) {
  if (!token) return false;
  try {
    const payload = JSON.parse(atob(token.split('.')[1]));
    return payload.roles && payload.roles.includes('ROLE_ADMIN');
  } catch {
    return false;
  }
}

const AdminPanel = ({ token }) => {
  if (!isAdmin(token)) {
    return (
      <div style={{ maxWidth: 800, margin: '0 auto', color: 'red' }}>
        <h2>Access Denied</h2>
        <p>You do not have permission to view this page.</p>
      </div>
    );
  }

  return (
    <div style={{ maxWidth: 800, margin: '0 auto' }}>
      <h2>Admin Panel</h2>
      <section>
        <h3>Books</h3>
        <AddBookForm token={token} />
        <BookList token={token} />
      </section>
      <section>
        <h3>Authors</h3>
        <EntityAddForm token={token} entityType="authors" />
        <EntityList token={token} entityType="authors" />
      </section>
      <section>
        <h3>Genres</h3>
        <EntityAddForm token={token} entityType="genres" />
        <EntityList token={token} entityType="genres" />
      </section>
      <section>
        <h3>Tags</h3>
        <EntityAddForm token={token} entityType="tags" />
        <EntityList token={token} entityType="tags" />
      </section>
    </div>
  );
};

export default AdminPanel;