import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

function parseJwt(token) {
  if (!token) return null;
  try {
    return JSON.parse(atob(token.split('.')[1]));
  } catch {
    return null;
  }
}

const BookDetails = ({ token }) => {
  const { id } = useParams();
  const [book, setBook] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(false);

  const [comments, setComments] = useState([]);
  const [commentText, setCommentText] = useState('');
  const [commentMsg, setCommentMsg] = useState('');

  const user = parseJwt(token);
  const isAdmin = user?.roles?.includes('ROLE_ADMIN');

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
      setError(true);
    } finally {
      setLoading(false);
    }
  };

  const fetchComments = async () => {
    try {
      const res = await fetch(`/api/comments/book/${id}`);
      if (!res.ok) {
        setComments([]);
        return;
      }
      const data = await res.json();
      setComments(data);
    } catch {
      setComments([]);
    }
  };

  useEffect(() => {
    fetchBook();
    fetchComments();
  }, [id]);

  const handleAddComment = async e => {
  e.preventDefault();
  setCommentMsg('');
  if (!token) {
    setCommentMsg('You must be logged in to comment.');
    return;
  }
  const res = await fetch(`/api/comments/book/${id}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`
    },
    body: JSON.stringify({ comment: commentText })
  });
  if (res.ok) {
    setCommentText('');
    setCommentMsg('Comment added!');
    fetchComments();
  } else {
    let data = {};
    try {
      data = await res.json();
    } catch {
      setCommentMsg('Failed to add comment.');
      return;
    }
    setCommentMsg(data.error || 'Failed to add comment.');
  }
};

  const handleDeleteComment = async commentId => {
    if (!token) return;
    await fetch(`/api/comments/${commentId}`, {
      method: 'DELETE',
      headers: { Authorization: `Bearer ${token}` }
    });
    fetchComments();
  };

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

      <section style={{ maxWidth: 600, margin: '2em auto' }}>
        <h2>Comments</h2>
        {token && (
          <form onSubmit={handleAddComment} style={{ marginBottom: 16 }}>
            <textarea
              value={commentText}
              onChange={e => setCommentText(e.target.value)}
              placeholder="Add a comment..."
              required
              rows={3}
              style={{ width: '100%' }}
            />
            <button type="submit">Add Comment</button>
            {commentMsg && <div>{commentMsg}</div>}
          </form>
        )}
        {!token && <div style={{ marginBottom: 16 }}>Log in to add comments.</div>}
        <ul>
          {comments.length === 0 && <li>No comments yet.</li>}
          {comments.map(comment => (
            <li key={comment.id ?? Math.random()} style={{ marginBottom: 12 }}>
              <div>
                <strong>
                  User #{comment.userId !== undefined && comment.userId !== null ? comment.userId : 'Unknown'}
                </strong>{' '}
                ({comment.date ? comment.date : 'No date'}):<br />
                {comment.comment ? comment.comment : '[No comment text]'}
              </div>
              {(isAdmin || (user && comment.userId === user.userId)) && (
                <button
                  onClick={() => handleDeleteComment(comment.id)}
                  style={{ marginTop: 4 }}
                >
                  Delete
                </button>
              )}
            </li>
          ))}
        </ul>
      </section>
    </div>
  );
};

export default BookDetails;