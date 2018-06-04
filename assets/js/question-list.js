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
        this.onPagePrev = this.onPagePrev.bind(this);
        this.onPageNext = this.onPageNext.bind(this);
    }

    onSearchChange(event) {
        this.setState({
            search: event.target.value
        });
    }


    onSearchClick() {
        if(this.state.search === '') return;
        this.handleSearch(1);
    }

    onPagePrev() {
        if(Number(this.state.page)-1 === 0) return;
        this.handleSearch(Number(this.state.page)-1)
    }

    onPageNext() {
        if(Number(this.state.page) === Number(this.state.totalPages)) return;
        this.handleSearch(Number(this.state.page)+1)
    }



    handleSearch(page = null) {
        ApiClient.get(this.state.search !== '' ? api.question.search : api.question.show,
            this.state.search !== '' ? {
                params: {
                    page: page === null ? this.state.page : page,
                    param: this.state.search
                }} : {
                params: {
                    page: page === null ? this.state.page : page
                }
            }
        ).
        then(questions => {
            this.setState({
                questions: questions.data,
                totalPages: questions.totalPages,
                page: page === null ? this.state.page : page
            })
        });
    }
    componentDidMount() {
        this.handleSearch();
    }

    componentDidUpdate() {
        history.pushState(null, null, "/questions/" + this.state.page+  (this.state.search !== "" ? "/" : "") + this.state.search);
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
                        <PaginationItem key={i} onClick={() => this.handleSearch(i)} active={Number(this.state.page) === i}>
                            <PaginationLink>
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
                        <Col sm={1}>
                            <Pagination>
                                <PaginationItem disabled={ Number(this.state.page)-1 === 0} onClick={this.onPagePrev}>
                                    <PaginationLink previous/>
                                </PaginationItem>
                                {pagesList()}
                                <PaginationItem disabled={ Number(this.state.page) === Number(this.state.totalPages)} onClick={this.onPageNext}>
                                    <PaginationLink next  />
                                </PaginationItem>
                            </Pagination>
                        </Col>

                        <Col sm={2}>
                            <Button className="text-white" style={{backgroundColor:"#ff6b00"}} >
                                Užduoti klausimą
                            </Button>
                        </Col>

                        <Col sm={{size:6, offset: 3}}>
                            <InputGroup className="mb-3">
                                <Input onChange={this.onSearchChange} value={this.state.search} placeholder="Įveskite tekstą arba pavadinimą"
                                       onKeyDown={event => {
                                           if(event.key === 'Enter') {
                                               event.preventDefault();
                                               event.stopPropagation();
                                               this.onSearchClick();
                                           }
                                       }}/>
                                <InputGroupAddon addonType="append">
                                    <Button className="text-white" style={{backgroundColor:"#ff6b00"}} onClick={this.onSearchClick}>
                                        Ieškoti
                                    </Button>
                                </InputGroupAddon>
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

                    <Row>
                        <Col sm={12}>
                            <Pagination>
                                <PaginationItem disabled={ Number(this.state.page)-1 === 0} onClick={this.onPagePrev}>
                                    <PaginationLink previous/>
                                </PaginationItem>
                                {pagesList()}
                                <PaginationItem disabled={ Number(this.state.page) === Number(this.state.totalPages)} onClick={this.onPageNext}>
                                    <PaginationLink next  />
                                </PaginationItem>
                            </Pagination>
                        </Col>
                    </Row>
                </div>
            );
        }
    }
}
const questionListElement = document.getElementById('question-list');
ReactDOM.render(<QuestionList page={questionListElement.getAttribute('page')} text={questionListElement.getAttribute('text')}/>,
    questionListElement
);


















