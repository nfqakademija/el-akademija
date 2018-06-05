import React from 'react';
import ReactDOM from 'react-dom';
import {Link} from 'react-router-dom';

import {
    Modal, ModalHeader, ModalBody, ModalFooter,
    Pagination, PaginationItem, PaginationLink,
    InputGroup, InputGroupAddon, Input, Button, Container, Row, Col,
    Form, FormGroup, FormFeedback, Label
} from 'reactstrap';

import ApiClient from './api-client';
import Question from './question';
import moment from "moment/moment";

const {api} = require('./api');


class QuestionList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            modal: false,
            questions:null,
            search: this.props.text,
            page: this.props.page,
            totalPages: null,
            name: '',
            category: {
                name: '',
                id: ''
            },
            text: '',
            errors: [],
            categories: null,
        };

        this.onSearchChange = this.onSearchChange.bind(this);
        this.onSearchClick = this.onSearchClick.bind(this);
        this.onPagePrev = this.onPagePrev.bind(this);
        this.onPageNext = this.onPageNext.bind(this);

        this.modalToggle = this.modalToggle.bind(this);
        this.handleModalSubmit = this.handleModalSubmit.bind(this);

        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeCategory = this.handleChangeCategory.bind(this);
        this.handleChangeText = this.handleChangeText.bind(this);
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
        ApiClient.all([
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
            ),
            ApiClient.get(api.category.show),
        ]).
        then(ApiClient.spread((questions, categories) => {
            this.setState({
                questions: questions.data,
                totalPages: questions.totalPages,
                page: page === null ? this.state.page : page,
                categories: categories.data,
                category: {
                    name: categories.data[0].name,
                    id: categories.data[0].id
                }
            });
        }));
    }
    componentDidMount() {
        this.handleSearch();
    }

    componentDidUpdate() {
        history.pushState(null, null, "/questions/" + this.state.page+  (this.state.search !== "" ? "/" : "") + this.state.search);
    }

    modalToggle = () => {
        this.setState({
            modal: !this.state.modal
        });
    };

    handleModalSubmit = () => {

    }

    handleChangeName(event) {
        this.setState({name: event.target.value});
    }

    handleChangeCategory(event) {
        this.setState({
            category: {
                name: event.target.value,
                id: Number(event.target[event.target.selectedIndex].getAttribute('data-id'))
            }
        });
    }

    handleChangeText(event) {
        this.setState({text: event.target.value});
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
                        <Col sm={3} md={2}>
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

                        {/*<Col sm={2} md={2}>
                            <Button onClick={this.modalToggle} className="text-white" style={{backgroundColor:"#ff6b00"}} >
                                Užduoti klausimą
                            </Button>
                        </Col>*/}

                        <Col sm={{size:6, offset: 1}} md={{size:7}}>
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


                    <Modal isOpen={this.state.modal} fade={true} toggle={this.modalToggle} size='lg'>
                        <Form onSubmit={this.handleModalSubmit}>
                            <ModalHeader toggle={this.modalToggle}>Klausimo uždavimas</ModalHeader>
                            <ModalBody>
                                <Container>
                                    <FormGroup row>
                                        <Label for="questionName" sm={2}>Tema</Label>
                                        <Col sm={10}>
                                            <Input invalid={this.state.errors.name != null} type="text" name="questionName"
                                                   id="questionName" placeholder="Temos pavadinimas" value={this.state.name}
                                                   onChange={this.handleChangeName}/>
                                            <FormFeedback
                                                valid={this.state.errors.name == null}>{this.state.errors.name != null ? this.state.errors.name[0] : null}</FormFeedback>
                                        </Col>
                                    </FormGroup>
                                    <FormGroup row>
                                        <Label for="questionCategory" sm={2}>Kategorija</Label>
                                        <Col sm={10}>
                                            <Input type="select" name="questionCategory" id="questionCategory"
                                                   value={this.state.category.name} onChange={this.handleChangeCategory}>
                                                {this.state.categories.map((category) =>
                                                    <option style={{
                                                        color: category.color,
                                                        textDecoration: 'bold'
                                                    }}
                                                            key={category.id}
                                                            data-id={category.id}>{category.name}</option>
                                                )}
                                            </Input>
                                        </Col>
                                    </FormGroup>
                                    <FormGroup row>
                                        <Label for="questionDescription" sm={2}>Aprašymas</Label>
                                        <Col sm={10}>
                                            <Input
                                                style={{minHeight: '200px'}}
                                                type="textarea"
                                                name="questionDescription"
                                                id="questionDescription"
                                                value={this.state.text}
                                                onChange={this.handleChangeText}
                                                invalid={this.state.errors.description != null}/>

                                            <FormFeedback
                                                valid={this.state.errors.description == null}>{this.state.errors.description != null ? this.state.errors.description[0] : null}</FormFeedback>
                                        </Col>
                                    </FormGroup>
                                </Container>
                            </ModalBody>
                            <ModalFooter>
                                <Button color="success" type='submit'>Užduoti klausimą</Button>
                                <Button color="danger" onClick={this.modalToggle}>Atšaukti</Button>
                            </ModalFooter>
                        </Form>
                    </Modal>
                </div>
            );
        }
    }
}
const questionListElement = document.getElementById('question-list');
ReactDOM.render(<QuestionList page={questionListElement.getAttribute('page')} text={questionListElement.getAttribute('text')}/>,
    questionListElement
);


















