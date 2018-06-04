import React from 'react';
import ApiClient from './api-client';
const {api} = require('./api');

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

    handleSubmit() {
        ApiClient.post(api.question.post_comment,
            {
                'comment[question]': this.props.questionId,
                'comment[user]': this.props.userId,
                'comment[text]': this.state.value
            });

    }

    render() {
        return (
            <div className="container-fluid">
            <div className="row">
                <div className="col-sm-12">
            <div className="post-editor">
                <form onSubmit={this.handleSubmit}>
                    <textarea name="post-field" id="post-field" className="post-field"
                              placeholder="Type..." value={this.state.value} onChange={this.handleChange}>
                </textarea>
                    <div className="d-flex">
                        <div className="button-orange">
                            <button className="btn button-round" type="submit">Komentuoti</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            </div>
            </div>
        )
    }
}

export default CommentInput;