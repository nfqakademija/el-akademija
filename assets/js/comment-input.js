import React from 'react';
import axios from "axios"
const qs = require('qs');
//import ApiClient from './ApiClient';

class CommentInput extends React.Component {

    constructor(props) {
        super(props);
        this.state = {};

        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        this.setState({value: event.target.value});
    }

    handleSubmit(event) {
        event.preventDefault();

        // SITA NESAMONE NEVEIKIA. NEI VIENAS METODAS.
        // Nesvarbu ar tai qs biblioteka, ar tai queryString biblioteka
        // taip pat headers pridejimas irgi nepadeda.



        /*ApiClient.post('/api/comment/new', {
            "question": this.props.questionId,
            "user": 1,
            "text": this.state.value
        }).then((response) => console.log(response));*/

        axios.post('/api/comment/new',
            qs.stringify({
                question: this.props.questionId,
                user: 1,
                text: this.state.value
            }),
            {
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            }
        ).then((response) => console.log(response));


    }

    render() {
        return (
            <div className="post-editor">
                <form onSubmit={this.handleSubmit}>
                    <textarea name="post-field" id="post-field" className="post-field"
                              placeholder="Type..." value={this.state.value} onChange={this.handleChange}>
                </textarea>
                    <div className="d-flex">
                        <button className="btn btn-orange" type="submit">Post</button>
                    </div>
                </form>
            </div>
        )
    }
}

export default CommentInput;