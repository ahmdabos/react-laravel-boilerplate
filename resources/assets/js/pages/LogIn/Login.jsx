import React from 'react'
import axios from 'axios'
import { connect } from 'react-redux'
import { push } from 'react-router-redux'
import { SubmissionError } from 'redux-form'

import LogInForm from './LogInForm'

export const LogInComponent = (props) => {
  const { attemptLogin } = props

  return (
    <LogInForm onSubmit={attemptLogin} />
  )
}

const parseValidationFromResponse = (response) => {
  let errors = {}

  if (response.errors === true && response.messages === 'Incorrect login details') {
    errors.email = 'Incorrect login details'
  }

  return errors
}

const mapDispatchToProps = (dispatch) => ({
  attemptLogin: (loginDetails) => {
    return axios.post('/api/login', loginDetails)
      .then((response) => {
        dispatch(push('/overview'))
      })
      .catch((error) => {
        if (error.response.status === 400) {
          throw new SubmissionError(parseValidationFromResponse(error.response.data.messages))
        }
      })
  }
})

export const LogIn = connect(
  null,
  mapDispatchToProps
)(LogInComponent)
