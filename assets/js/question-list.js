import React from 'react';
import ReactDOM from 'react-dom';
import {Link} from 'react-router-dom';
import {
    Pagination, PaginationItem, PaginationLink,
    InputGroup, InputGroupAddon, Input, Button, Row, Col
} from 'reactstrap';

import ApiClient from './api-client';
import Question from './question';

const {api} = require('./api');


class QuestionList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            questions:null,
            search: this.props.text,
            page: this.props.page,
            totalPages: null
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
        this.handleSearch();
    }

    handleSearch() {
        ApiClient.get(this.state.search !== '' ? api.question.search : api.question.show,
            this.state.search !== '' ? {
                params: {
                    page: this.state.page,
                    param: this.state.search
                }} : {
                params: {
                    page: this.state.page
                }
            }
        ).
        then(questions => {
            this.setState({
                questions: questions.data,
                totalPages: questions.totalPages
            })
        });
    }
    componentDidMount() {
        this.handleSearch();
    }

    render() {

        // Kai dar neuzkrauta informacija
        if(!this.state.questions) {
            return <div>Loading...</div>
        } else {

            const { questions } = {...this.state};
            const pagesList = () => {
                const buttons = [];
                for(let i = 1; i <= this.state.totalPages; i++) {
                    buttons.push(
                        <PaginationItem key={i}>
                            <PaginationLink href={"/questions/"+ i +  (this.state.search !== "" ? "/" : "") + this.state.search}>
                                {i}
                            </PaginationLink>
                        </PaginationItem>
                    )
                }
                return buttons;
            };
            return (
                <div>

                    <Row>
                        <Col sm={6}>
                            <Pagination>
                                <PaginationItem>
                                    <PaginationLink previous href="#" />
                                </PaginationItem>
                                {pagesList()}
                                <PaginationItem>
                                    <PaginationLink next href="#" />
                                </PaginationItem>
                            </Pagination>
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
ReactDOM.render(<QuestionList page={questionListElement.getAttribute('page')} text={questionListElement.getAttribute('text')}/>,
    questionListElement
);


















