import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const CreateUser = () => {
  const [inputs, setInputs] = useState({
    username: '',
    email: '',
    mobile: '',
  });

  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post('http://localhost:8005/api/', inputs);
      if (!response.data.error) {
        navigate('/');
      }
    } catch (error) {
      console.log(error.message);
    }
  };

  const handleChanges = (e) => {
    const { name, value } = e.target;
    setInputs((values) => {
      return { ...values, [name]: value };
    });
  };

  return (
    <main>
      <form onSubmit={handleSubmit}>
        <fieldset>
          <legend>Create User</legend>
          <div>
            <label htmlFor='name'>Name</label>
            <input
              type='text'
              name='username'
              id='username'
              onChange={handleChanges}
              value={inputs.name}
            />
          </div>
          <div>
            <label htmlFor='email'>Email</label>
            <input
              type='text'
              name='email'
              id='email'
              onChange={handleChanges}
              value={inputs.email}
            />
          </div>
          <div>
            <label htmlFor='mobile'>Mobile</label>
            <input
              type='text'
              name='mobile'
              id='mobile'
              onChange={handleChanges}
              value={inputs.mobile}
            />
          </div>
          <button onClick={handleSubmit}>Create</button>
        </fieldset>
      </form>
    </main>
  );
};

export default CreateUser;
