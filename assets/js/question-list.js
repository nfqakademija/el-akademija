import React from 'react';
import ReactDOM from 'react-dom';
import {InputGroup, InputGroupAddon, Input, Button, Row, Col} from 'reactstrap';

import ApiClient from './api-client';
import Question from './question';

const {api} = require('./api');


class QuestionList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            questions:null,
            search: '',
        };

        this.onSearchChange = this.onSearchChange.bind(this);
        this.onSearchClick = this.onSearchClick.bind(this);
    }

    onSearchChange(event) {
        this.setState({
            search: event.target.value
        });
    }

    onSearchClick() {
        if(this.state.search === '') return;
        ApiClient.get(api.question.search, {
            params: {
                param: this.state.search
            }
        }).
            then(questions => {
                this.setState({
                    questions: questions.data
                })
        });
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
                <div>
                    <Row>
                        <Col sm={6}>

                        </Col>
                        <Col sm={6}>
                            <InputGroup className="mb-3">
                                <Input onChange={this.onSearchChange} value={this.state.search} placeholder="Įveskite tekstą arba pavadinimą" />
                                <InputGroupAddon addonType="append"><Button className="text-white" style={{backgroundColor:"#ff6b00"}} onClick={this.onSearchClick}>Ieškoti</Button></InputGroupAddon>
                            </InputGroup>
                        </Col>
                    </Row>
                    <div className="stream-posts">
                        {questions.map(question =>
                            <Question
                                key={question.id}
                                question={question}/>
                        )}
                    </div>
                </div>
            );
        }
    }
}
const questionListElement = document.getElementById('question-list');
ReactDOM.render(<QuestionList/>,
    questionListElement
);


















