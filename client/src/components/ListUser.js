import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

const ListUser = () => {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    getUsers();
  }, []);

  const getUsers = async () => {
    const response = await axios.get('http://localhost:8005/api/');
    setUsers(response.data);
  };

  const deleteUser = async (id) => {
    await axios.delete(`http://localhost:8005/api/index.php/user/${id}/delete`);
    getUsers();
  };

  return (
    <main>
      <h2>List Users</h2>
      <div className='users'>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            {users.map((user) => (
              <tr key={user.id}>
                <td>{user.id}</td>
                <td>{user.username}</td>
                <td>{user.email}</td>
                <td>{user.mobile}</td>
                <td>
                  <Link to={`user/${user.id}/edit`}>Edit</Link>
                </td>
                <td>
                  <button onClick={() => deleteUser(user.id)}>Delete</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </main>
  );
};

export default ListUser;
