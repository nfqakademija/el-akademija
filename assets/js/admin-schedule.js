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
    Form, FormGroup, FormFeedback, Label, Input, FormText,
    Badge
} from 'reactstrap';
import InputMoment from 'input-moment';

BigCalendar.momentLocalizer(moment);

class CustomMonthEvent extends React.Component {
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
            <div id={`Popover${this.props.event.id}`} onClick={this.toggle} style={{cursor: 'pointer'}}>
                <div className="d-flex justify-content-between" >
                    <div className="p-0">{this.props.event.title}</div>
                    <div className="p-0">{moment(this.props.event.start).format("HH:mm")} - {moment(this.props.event.end).format("HH:mm")}</div>
                </div>
                <Popover placement="bottom" isOpen={this.state.popoverOpen} target={`Popover${this.props.event.id}`} toggle={this.toggle}>
                    <PopoverHeader style={{
                        backgroundColor: this.props.event.category.color,
                        color:'white'
                    }}>{this.props.event.category.name}</PopoverHeader>
                    <PopoverBody>{this.props.event.description}</PopoverBody>
                </Popover>
            </div>
        );
    }
}

class CustomWeekEvent extends React.Component {
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
            <div id={`Popover${this.props.event.id}`} onClick={this.toggle} style={{cursor: 'pointer'}}>
                {this.props.event.title}
                <Popover placement="bottom" isOpen={this.state.popoverOpen} target={`Popover${this.props.event.id}`} toggle={this.toggle}>
                    <PopoverHeader style={{
                        backgroundColor: this.props.event.category.color,
                        color:'white'
                    }}>{this.props.event.category.name}</PopoverHeader>
                    <PopoverBody>{this.props.event.description}</PopoverBody>
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
            },
            lector: {
                fullname: this.props.lectors[0].firstname + ' ' + this.props.lectors[0].lastname,
                id: this.props.lectors[0].id
            },
            errors: [],
            startdate: moment(this.props.event.start),
            enddate: moment(this.props.event.end),

            startPopover: false,
            endPopover: false,
        };
        this.handleChangeStart = this.handleChangeStart.bind(this);
        this.handleStartPopover = this.handleStartPopover.bind(this);
        this.handleChangeEnd = this.handleChangeEnd.bind(this);
        this.handleEndPopover = this.handleEndPopover.bind(this);
        this.handleChangeCourse = this.handleChangeCourse.bind(this);
        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeCategory = this.handleChangeCategory.bind(this);
        this.handleChangeLector = this.handleChangeLector.bind(this);
        this.handleChangeDescription = this.handleChangeDescription.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }


    handleChangeStart = startdate => {
        this.setState({
            startdate
        });
    };

    handleStartPopover() {
        this.setState({
            startPopover:!this.state.startPopover
        });
    }

    handleChangeEnd = enddate => {
        this.setState({
            enddate
        });
    };

    handleEndPopover() {
        this.setState({
            endPopover:!this.state.endPopover
        });
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

    handleChangeLector(event) {
        this.setState({
            lector: {
                fullname: event.target.value,
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
                'lecture[lector]': this.state.lector.id,
                'lecture[description]': this.state.description,
                'lecture[start]': moment(this.props.event.start).format('YYYY-MM-DD HH:mm:ss'), // 0000-00-00 00:00:00
                'lecture[end]': moment(this.props.event.end).format('YYYY-MM-DD HH:mm:ss')
            }).then((response) => {
            if (response.data.success) {
                this.props.confirm();
            }
            }).catch((error) => {
                if(error.response.data.errors) {
                    this.setState({
                        errors: error.response.data.errors
                    })
                }
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
                                <Label xs={9} sm={9} md={10} lg={6}>

                                    <div className="d-flex justify-content-between">
                                        <div className="p-0">
                                            {this.props.event !== null
                                                ? this.state.startdate.format("dddd, MMMM Do YYYY, HH:mm")
                                                : null}

                                        </div>
                                        <div className="p-0">
                                            <h6><Badge id="ChangeStartDate" onClick={this.handleStartPopover} color="secondary" style={{cursor:"pointer"}}>Keisti</Badge></h6>
                                            <Popover placement="bottom" isOpen={this.state.startPopover} target="ChangeStartDate" toggle={this.handleStartPopover}>

                                                <InputMoment
                                                    moment={this.state.startdate}
                                                    onChange={this.handleChangeStart}
                                                    minStep={5}
                                                />
                                            </Popover>
                                        </div>
                                    </div>

                                </Label>
                            </FormGroup>
                            <FormGroup row>
                                <Label sm={2}>Pabaiga</Label>
                                <Label xs={9} sm={9} md={10} lg={6}>
                                    <div className="d-flex justify-content-between">
                                        <div className="p-0">
                                            {this.props.event !== null
                                                ? this.state.enddate.format("dddd, MMMM Do YYYY, HH:mm")
                                                : null}

                                        </div>
                                        <div className="p-0">
                                            <h6><Badge id="ChangeEndDate" onClick={this.handleEndPopover} color="secondary" style={{cursor:"pointer"}}>Keisti</Badge></h6>
                                            <Popover placement="bottom" isOpen={this.state.endPopover} target="ChangeEndDate" toggle={this.handleEndPopover}>

                                                <InputMoment
                                                    moment={this.state.enddate}
                                                    onChange={this.handleChangeEnd}
                                                    minStep={5}
                                                />
                                            </Popover>
                                        </div>
                                    </div>
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
                                <Input invalid={this.state.errors.name != null} type="text" name="lectureName" id="lectureName" placeholder="Paskaitos pavadinimas" value={this.state.name} onChange={this.handleChangeName}/>
                                <FormFeedback valid={this.state.errors.name == null}>{this.state.errors.name != null ? this.state.errors.name[0] : null}</FormFeedback>
                            </Col>
                        </FormGroup>
                        <FormGroup row>
                            <Label for="lectureCategory" sm={2}>Paskaitos tipas</Label>
                            <Col sm={10}>
                                <Input type="select" name="lectureCategory" id="lectureCategory" value={this.state.category.name} onChange={this.handleChangeCategory}>
                                    {this.props.categories.map((category) =>
                                        <option style={{
                                            color: category.color,
                                            textDecoration:'bold'}}
                                                key={category.id}
                                                data-id={category.id}>{category.name}</option>
                                    )}
                                </Input>
                            </Col>
                        </FormGroup>
                        <FormGroup row>
                            <Label for="lectureLector" sm={2}>Lektorius</Label>
                            <Col sm={10}>
                                <Input type="select" name="lectureLector" id="lectureLector" value={this.state.lector.fullname} onChange={this.handleChangeLector}>
                                    {this.props.lectors.map((lector) =>
                                        <option
                                            key={lector.id}
                                            data-id={lector.id}>{lector.firstname} {lector.lastname}</option>
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
                                    onChange={this.handleChangeDescription}
                                    invalid={this.state.errors.description != null}/>

                                <FormFeedback valid={this.state.errors.description == null}>{this.state.errors.description != null ? this.state.errors.description[0] : null}</FormFeedback>
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
            courses:null,
            lectors: null,
        },

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
            ApiClient.get(api.course.show, {
                params: {
                    order: 'ASC'
                }
            }),
            ApiClient.get(api.user.show)
        ]).then(ApiClient.spread((lectures, categories, courses, lectors) => {
            this.setState({
                lectures: lectures.data,
                categories: categories.data,
                courses: courses.data,
                lectors: lectors.data,
            });
        }));
    };

    confirm = () => {
        this.update();
        this.toggle();
    };

    render() {


        const events = [];
        const {modal, event, lectures, categories, courses, lectors} = {...this.state};

        if(lectures && categories && lectors) {

            lectures.forEach(l => {

                events.push({
                    id: l.id,
                    title: l.name,
                    start: new Date(l.start),
                    end: new Date(l.end),
                    category: l.category,
                    lector: l.lector,
                    description: l.description
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
                        onSelecting={() => false}
                        onView={(view) => {
                            this.setState({currentView: view});
                        }}

                        eventPropGetter={
                            (event, start, end, isSelected) => {
                                let newStyle = {
                                    color: 'white',
                                    backgroundColor: event.category.color
                                };
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
                            month: {
                                event: CustomMonthEvent
                            },
                            week: {
                                event: CustomWeekEvent
                            },
                        }}
                        onSelectSlot={s => this.toggle(s)}
                    />
                    {modal !== false ?
                        <EventModal modal={modal}
                                    toggle={this.toggle}
                                    event={event}
                                    categories={categories}
                                    courses={courses}
                                    lectors={lectors}
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