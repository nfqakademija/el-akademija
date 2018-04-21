import React from 'react';
import ReactDOM from 'react-dom';

import ApiClient from './api-client';
import Question from './question';

const {api} = require('./api');


class QuestionList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            questions:null
        };
    }

    componentDidMount() {
        ApiClient.get(api.question.show)
            .then(questions => {
                this.setState({
                    questions: questions.data
                })
            });


    }

    render() {

        // Kai dar neuzkrauta informacija
        if(!this.state.questions) {
            return <div>Loading...</div>
        } else {

            const { questions } = {...this.state};
            return (
                <div className="stream-posts">
                    {questions.map(question =>
                        <Question
                            key={question.id}
                            question={question}/>
                    )}
                </div>
            );
        }
    }
}
const questionListElement = document.getElementById('question-list');
ReactDOM.render(<QuestionList/>,
    questionListElement
);

















