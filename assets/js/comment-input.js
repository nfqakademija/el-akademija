import React from 'react';
import ApiClient from './ApiClient';

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
        ApiClient.post('/api/comment/new',
            {
                'comment[question]': this.props.questionId,
                'comment[user]': 1,
                'comment[text]': this.state.value
            }).
        then((response) => console.log(response));

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