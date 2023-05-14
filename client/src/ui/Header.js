import React from 'react';
import { Link } from 'react-router-dom';

const Header = () => {
  return (
    <header>
      <h1>Full-Stack App</h1>
      <nav>
        <ul>
          <li>
            <Link to='/'>List Users</Link>
          </li>
          <li>
            <Link to='/user/save'>Create User</Link>
          </li>
        </ul>
      </nav>
    </header>
  );
};

export default Header;
