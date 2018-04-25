// Paderinti eventus, savaites skyriuje jeigu keletas eventu tuo paciu metu, tada gaunas overlapsingas
// ir tada rodo tik data, ir nebegalima paspausti ant teksto, kuris ismeta popoveri.

import React from 'react';
import BigCalendar from 'react-big-calendar';
import moment from 'moment';
import 'moment/locale/lt';
import ReactDOM from "react-dom";
import ApiClient from "./api-client";
const {api} = require('./api');
import { Popover, PopoverHeader, PopoverBody,
    Button, Modal, ModalHeader, ModalBody, ModalFooter,
    Container, Row, Col,
    Form, FormGroup, Label, Input, FormText
} from 'reactstrap';

BigCalendar.momentLocalizer(moment);

const CategoryColors = [
    {category:'Backend', color:'blue'},
    {category:'Frontend', color:'green'},
    {category:'Mysql', color:'rgb(255, 107, 0)'},
    {category:'UX', color:'red'},
];

class CustomEvent extends React.Component {
    constructor(props){
        super(props);

        this.toggle = this.toggle.bind(this);
        this.state = {
            popoverOpen: false
        };


    }

    toggle() {
        this.setState({
            popoverOpen: !this.state.popoverOpen
        });
    }

    render(){
        return (
            <div style={{height: '100%'}}>
                <div id={`Popover${this.props.event.id}`} onClick={this.toggle} style={{height: '100%'}}>
                    {this.props.event.title}
                </div>
                <Popover placement="left" isOpen={this.state.popoverOpen} target={`Popover${this.props.event.id}`} toggle={this.toggle}>
                    <PopoverHeader style={{
                        backgroundColor: CategoryColors.find(c => c.category === this.props.event.category) != null ? CategoryColors.find(c => c.category === this.props.event.category).color : 'white',
                        color:'white'
                    }}>{this.props.event.title}</PopoverHeader>
                    <PopoverBody>{this.props.event.category}</PopoverBody>
                </Popover>
            </div>
        );
    }
}

class EventModal extends React.Component {

    constructor(props) {
        super(props);

        let today = new Date();
        this.currentCourse = this.props.courses.find(course => {
                let startdate = new Date(course.start);
                let enddate = new Date(course.end);
                return course.name === "Kaunas | Pavasario semestras 2018" && startdate < today && enddate > today;
            }
        );

        this.state = {
            name: '',
            category: {
                name: this.props.categories[0].name,
                id: this.props.categories[0].id
            },
            description: '',
            course: {
                /*name: this.props.courses[0].name,
                id: this.props.courses[0].id*/
                name: this.currentCourse.name,
                id: this.currentCourse.id
            }
        };
        this.handleChangeCourse = this.handleChangeCourse.bind(this);
        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeCategory = this.handleChangeCategory.bind(this);
        this.handleChangeDescription = this.handleChangeDescription.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }



    handleChangeCourse(event) {
        this.setState({
            course: {
                name: event.target.value,
                id: Number(event.target[event.target.selectedIndex].getAttribute('data-id'))
            }});
    }
    handleChangeName(event) {
        this.setState({name: event.target.value});
    }
    handleChangeCategory(event) {
        this.setState({
            category: {
                name: event.target.value,
                id: Number(event.target[event.target.selectedIndex].getAttribute('data-id'))
            }});
    }

    handleChangeDescription(event) {
        this.setState({description: event.target.value});
    }

    handleSubmit(event) {
        event.preventDefault();
        ApiClient.post(api.lecture.new,
            {
                'lecture[course]': this.state.course.id,
                'lecture[category]': this.state.category.id,
                'lecture[name]': this.state.name,
                'lecture[description]': this.state.description,
                'lecture[start]': moment(this.props.event.start).format('YYYY-MM-DD HH:mm:ss'), // 0000-00-00 00:00:00
                'lecture[end]': moment(this.props.event.end).format('YYYY-MM-DD HH:mm:ss')
            }).then((response) => {
            if (response.data.success) {
                console.log(response);
                this.props.confirm();
            }
            }).catch((error) => {
                console.log(error.response.data);
        });
    }

    render(){
        return (
            <Modal isOpen={this.props.modal} fade={true} toggle={this.props.toggle} size='lg'>
                <Form onSubmit={this.handleSubmit}>
                <ModalHeader toggle={this.props.toggle}>Paskaitos pridėjimas</ModalHeader>
                <ModalBody>
                    <Container>
                        <FormGroup>
                            <FormGroup row>
                                <Label sm={2}>Pradžia</Label>
                                <Label sm={10}>
                                    {this.props.event !== null ?
                                        moment(this.props.event.start).format("dddd, MMMM Do YYYY, HH:mm:ss")
                                        : null}
                                </Label>
                            </FormGroup>
                            <FormGroup row>
                                <Label sm={2}>Pabaiga</Label>
                                <Label sm={10}>
                                    {this.props.event !== null ?
                                        moment(this.props.event.end).format("dddd, MMMM Do YYYY, HH:mm:ss")
                                        : null}
                                </Label>
                            </FormGroup>
                        </FormGroup>
                        <FormGroup row>
                            <Label for="courseList" sm={2}>Kursas</Label>
                            <Col sm={10}>
                                <Input type="select" name="courseList" id="courseList" value={this.state.course.name} onChange={this.handleChangeCourse}>
                                    {this.props.courses.map((course) =>
                                        <option
                                            style={{
                                                color: course.id === this.currentCourse.id ? 'red' : null}}
                                            key={course.id}
                                            data-id={course.id}>{course.name}</option>
                                    )}
                                </Input>
                            </Col>
                        </FormGroup>
                        <FormGroup row>
                            <Label for="lectureName" sm={2}>Paskaitos pavadinimas</Label>
                            <Col sm={10}>
                                <Input type="text" name="lectureName" id="lectureName" placeholder="Paskaitos pavadinimas" value={this.state.name} onChange={this.handleChangeName}/>
                            </Col>
                        </FormGroup>
                        <FormGroup row>
                            <Label for="lectureCategory" sm={2}>Paskaitos tipas</Label>
                            <Col sm={10}>
                                <Input type="select" name="lectureCategory" id="lectureCategory" value={this.state.category.name} onChange={this.handleChangeCategory}>
                                    {this.props.categories.map((category) =>
                                        <option style={{
                                            color: CategoryColors.find(c => c.category === category.name) != null ? CategoryColors.find(c => c.category === category.name).color : 'white',
                                            textDecoration:'bold'}}
                                                key={category.id}
                                                data-id={category.id}>{category.name}</option>
                                    )}
                                </Input>
                            </Col>
                        </FormGroup>
                        <FormGroup row>
                            <Label for="lectureDescription" sm={2}>Paskaitos aprašymas</Label>
                            <Col sm={10}>
                                <Input
                                    style={{minHeight: '200px'}}
                                    type="textarea"
                                    name="lectureDescription"
                                    id="lectureDescription"
                                    value={this.state.description}
                                    onChange={this.handleChangeDescription}/>
                            </Col>
                        </FormGroup>
                    </Container>
                </ModalBody>
                <ModalFooter>
                    <Button color="success" type='submit'>Pridėti paskaitą</Button>
                    <Button color="danger" onClick={this.props.toggle}>Atšaukti</Button>
                </ModalFooter>
                </Form>
            </Modal>
        );
    }
}

class AdminSchedule extends React.Component {


    constructor(props) {
        super(props);
        this.state = {
            modal: false,
            event: null,
            lectures: null,
            categories:null,
            courses:null
        };

        this.toggle = this.toggle.bind(this);
        this.update = this.update.bind(this);
        this.confirm = this.confirm.bind(this);
    }

    componentDidMount() {
        this.update();
    }

    toggle = (e) => {
        this.setState({
            modal: !this.state.modal,
            event: this.state.modal === false ? {
                start: e.start,
                end: e.end,
            } : null
        });
    };

    update = () => {
        ApiClient.all([
            ApiClient.get(api.lecture.show),
            ApiClient.get(api.category.show),
            ApiClient.get(api.course.show("order=ASC"))
        ]).then(ApiClient.spread((lectures, categories, courses) => {
            this.setState({
                lectures: lectures.data,
                categories: categories.data,
                courses: courses.data
            });
        }));
    };

    confirm = () => {
        this.update();
        this.toggle();
    };

    render() {


        const events = [];
        const {modal, event, lectures, categories, courses} = {...this.state};

        if(lectures && categories) {

            lectures.forEach(l => {
                let start = new Date(l.start);
                let end = new Date(l.end);

                events.push({
                    id: l.id,
                    title: l.name,
                    start: start,
                    end: end,
                    category: l.category.name,
                })
            });

            return(
                <div>
                    <BigCalendar
                        selectable
                        culture='lt'
                        popup events={events}
                        step={60}
                        defaultDate={new Date()}
                        views={["month", "week", "day", "agenda"]}

                        eventPropGetter={
                            (event, start, end, isSelected) => {
                                let newStyle = {
                                    backgroundColor: "red",
                                    color: 'white',
                                };
                                newStyle.backgroundColor = CategoryColors.find(c => c.category === event.category) != null ? CategoryColors.find(c => c.category === event.category).color : 'white';
                                return {
                                    className: "",
                                    style: newStyle
                                };
                            }
                        }
                        messages={
                            {
                                'today': 'Šiandien',
                                'previous': 'Atgal',
                                'next': 'Kitas',
                                'month': 'Mėnuo',
                                'week': 'Savaitė',
                                'day': 'Diena',
                                'showMore': total => `+${total} Žiūrėti daugiau`
                            }
                        }
                        components={{
                            event: CustomEvent,
                        }}
                        onSelectSlot={s => this.toggle(s)}
                    />
                    {modal !== false ?
                        <EventModal modal={modal}
                                    toggle={this.toggle}
                                    event={event}
                                    categories={categories}
                                    courses={courses}
                                    confirm={this.confirm}/>
                        : null}
                </div>
            )

        } else {
            return(
                <div>

                </div>
            )
        }
    }
}

ReactDOM.render(<AdminSchedule/>, document.getElementById('admin-schedule'));