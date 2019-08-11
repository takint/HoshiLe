import React, { useState, useEffect } from 'react';
import { withRouter, Link } from 'react-router-dom';
import { History } from 'history';
import { Container, Row, Col, Alert, Form, Button, Spinner } from 'react-bootstrap';
import { USER_API } from '../config';
import { useSessionDispatch, LOGGED_IN } from '../Session';
import User from '../entity/User';
import { documentTitle } from '../util/documentTitle';
import { valueHandler } from '../util/valueHandler';
import { fetchUrl } from '../util/fetchUrl';
import { useFetchReducer, setFetchResult, START } from '../util/fetchReducer';

const UserLogin: React.FC<{ history: History }> = ({ history }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loginState, loginDispatch] = useFetchReducer();
  const sessionDispatch = useSessionDispatch();

  const loginDisabled = loginState.started || email === '' || password === '';

  useEffect(() => documentTitle('Log in'), []);
  useEffect(() => {
    if (loginState.started) {
      return fetchUrl('GET', USER_API, { email, password }, setFetchResult(loginDispatch, (user: User) => {
        sessionDispatch({ type: LOGGED_IN, userId: user.id, userName: user.name });
        history.push('/');
      }));
    }
  }, [loginState.started]); // eslint-disable-line react-hooks/exhaustive-deps

  return (
    <main className='py-4'>
      <Container>
        <Row className='justify-content-center'>
          <Col md={6}>
            <h3 className='mb-3'>Please Log in, or <Link to='/signup'>Sign up</Link></h3>
            {
              loginState.failed && <Alert variant='danger'>Login failed.</Alert>
            }
            <Form>
              <Form.Group>
                <Form.Label>Email</Form.Label>
                <Form.Control type='email' value={email} onChange={valueHandler(setEmail)} autoFocus />
              </Form.Group>
              <Form.Group>
                <Form.Label>Password</Form.Label>
                <Form.Control type='password' value={password} onChange={valueHandler(setPassword)} />
              </Form.Group>
              <Button type='submit' variant='primary' disabled={loginDisabled} onClick={() => loginDispatch(START)}>
                {
                  loginState.started && <Spinner as='span' className='mr-2' animation='border' size='sm' />
                }
                Log in
              </Button>
            </Form>
          </Col>
        </Row>
      </Container>
    </main>
  );
};

export default withRouter(UserLogin);
