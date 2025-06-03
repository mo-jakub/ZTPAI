import React, { useState } from 'react';
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

const sections = [
  { key: 'books', label: 'Books' },
  { key: 'authors', label: 'Authors' },
  { key: 'genres', label: 'Genres' },
  { key: 'tags', label: 'Tags' }
];

const AdminPanel = ({ token }) => {
  const [activeSection, setActiveSection] = useState(null);

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
      <nav style={{ display: 'flex', gap: 16, marginBottom: 24 }}>
        {sections.map(section => (
          <button
            key={section.key}
            onClick={() => setActiveSection(section.key)}
            style={{
              padding: '8px 16px',
              background: activeSection === section.key ? '#007bff' : '#eee',
              color: activeSection === section.key ? '#fff' : '#222',
              border: 'none',
              borderRadius: 4,
              cursor: 'pointer'
            }}
          >
            {section.label}
          </button>
        ))}
      </nav>

      {activeSection === 'books' && (
        <section>
          <h3>Books</h3>
          <AddBookForm token={token} />
          <BookList token={token} />
        </section>
      )}
      {activeSection === 'authors' && (
        <section>
          <h3>Authors</h3>
          <EntityAddForm token={token} entityType="authors" />
          <EntityList token={token} entityType="authors" />
        </section>
      )}
      {activeSection === 'genres' && (
        <section>
          <h3>Genres</h3>
          <EntityAddForm token={token} entityType="genres" />
          <EntityList token={token} entityType="genres" />
        </section>
      )}
      {activeSection === 'tags' && (
        <section>
          <h3>Tags</h3>
          <EntityAddForm token={token} entityType="tags" />
          <EntityList token={token} entityType="tags" />
        </section>
      )}
      {!activeSection && (
        <div style={{ marginTop: 40, textAlign: 'center', color: '#888' }}>
          <p>Select a section above to manage.</p>
        </div>
      )}
    </div>
  );
};

export default AdminPanel;