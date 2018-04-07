import React from 'react';
import ReactDOM from 'react-dom';
import ApiClient from './ApiClient'

class Question extends React.Component {


    componentDidMount() {
        console.log(this.props.questionId);
    }

    render() {
        return (
          <div>{this.props.questionId}</div>
        )
    }
}
const questionElement = document.getElementById('question');
ReactDOM.render(<Question questionId={questionElement.getAttribute('question-id')}/>,
    questionElement
);


















