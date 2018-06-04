import React from 'react';
import ReactDOM from "react-dom";

import ApiClient from './api-client';
const {api} = require('./api');

class Login extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            email: '',
            password: '',
            message: '',
        };

        this.handleEmailChange = this.handleEmailChange.bind(this);
        this.handlePasswordChange = this.handlePasswordChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleEmailChange(event) {
        this.setState({email: event.target.value});
    }

    handlePasswordChange(event) {
        this.setState({password: event.target.value});
    }

    handleSubmit(event) {
        event.preventDefault();
        ApiClient.post(api.auth.login,
            {
                'email': this.state.email,
                'password': this.state.password,
            }).then((response) => {
            if (response.data.success) {
                if (response.data.message) {
                    this.setState({
                        message: response.data.message
                    })
                }
                window.location.replace("/");
            } else {
                if (response.data.message) {
                    this.setState({
                        message: response.data.message
                    })
                }
            }
        }).catch((error) => {
            if (error.response.data.message) {
                this.setState({
                    message: error.response.data.message
                })
            }
        });

    }

    render() {
        return (
                <div className="login-form" onSubmit={this.handleSubmit}>
                    <h2 className="text-center">Prisijungimas</h2>
                    <form >
                        <div className="form-group">
                            <input type="email" className="form-control input-lg" name="email" placeholder="E-Mail" required="required"
                                   value={this.state.email} onChange={this.handleEmailChange}
                            />
                        </div>
                        <div className="form-group">
                            <input type="password" className="form-control input-lg" name="password" placeholder="Password" required="required"
                                   value={this.state.password} onChange={this.handlePasswordChange}
                            />
                        </div>
                        <div className="form-group">
                            <button type="submit" className="btn btn-primary btn-lg btn-block login-btn">Prisijungti</button>
                        </div>
                        <p className="hint-text">{this.state.message}</p>
                    </form>
                </div>
        );
    }
}

ReactDOM.render(<Login/>, document.getElementById('login'));


















