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
            <div>
                <div id={`Popover${this.props.event.id}`} onClick={this.toggle}>
                    {this.props.event.title}
                </div>
                <Popover placement="left" isOpen={this.state.popoverOpen} target={`Popover${this.props.event.id}`} toggle={this.toggle}>
                    <PopoverHeader style={{
                        backgroundColor: CategoryColors.find(c => c.category === this.props.event.category).color,
                        color:'white'
                    }}>{this.props.event.title}</PopoverHeader>
                    <PopoverBody>{this.props.event.category}</PopoverBody>
                </Popover>
            </div>
        );
    }
}

class ModalForm extends React.Component {

    constructor(props){
        super(props);
    }

    render(){
        return (
            <div>
                <Form>
                    <FormGroup >
                        <FormGroup row>
                            <Label sm={2}>Pradžia</Label>
                            <Label sm={10}>
                                {this.props.event !== null ? moment(this.props.event.start).format("dddd, MMMM Do YYYY, HH:mm:ss") : null}
                            </Label>
                        </FormGroup>
                        <FormGroup row>
                            <Label sm={2}>Pabaiga</Label>
                            <Label sm={10}>
                                {this.props.event !== null ? moment(this.props.event.end).format("dddd, MMMM Do YYYY, HH:mm:ss") : null}
                            </Label>
                        </FormGroup>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="lectureName" sm={2}>Paskaitos pavadinimas</Label>
                        <Col sm={10}>
                            <Input type="text" name="lectureName" id="lectureName" placeholder="Paskaitos pavadinimas" />
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="lectureCategory" sm={2}>Paskaitos tipas</Label>
                        <Col sm={10}>
                            <Input type="select" name="lectureCategory" id="lectureCategory" >
                                {this.props.categories.map((category) =>
                                    <option style={{
                                        color: CategoryColors.find(c => c.category === category.name).color,
                                        textDecoration:'bold'}}
                                            key={category.id}>{category.name}</option>
                                )}
                            </Input>
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="lectureDescription" sm={2}>Paskaitos aprašymas</Label>
                        <Col sm={10}>
                            <Input style={{minHeight: '200px'}} type="textarea" name="lectureDescription" id="lectureDescription" />
                        </Col>
                    </FormGroup>
                </Form>
            </div>
        );
    }
}

class EventModal extends React.Component {

    constructor(props) {
        super(props);
    }

    render(){
        return (
            <Modal isOpen={this.props.modal} fade={true} toggle={this.props.toggle} size='lg'>
                <ModalHeader toggle={this.props.toggle}>Paskaitos pridėjimas</ModalHeader>
                <ModalBody>
                    <Container>
                        <ModalForm event={this.props.event} categories={this.props.categories}/>
                    </Container>
                </ModalBody>
                <ModalFooter>
                    <Button color="success" onClick={this.props.toggle}>Pridėti paskaitą</Button>
                    <Button color="danger" onClick={this.props.toggle}>Atšaukti</Button>
                </ModalFooter>
            </Modal>
        );
    }
}

class AdminSchedule extends React.Component {


    constructor(props) {
        super(props);
        this.state = {
            lectures: null,
            modal: false,
            event: null,
            categories:null
        };

        this.toggle = this.toggle.bind(this);
    }

    componentDidMount() {

        ApiClient.all([
            ApiClient.get(api.lecture.show),
            ApiClient.get(api.category.show)
        ]).then(ApiClient.spread((lectures, categories) => {
            this.setState({
                lectures: lectures.data,
                categories: categories.data
            });
        }));
    }

    toggle = (e) => {
        this.setState({
            lectures: this.state.lectures,
            modal: !this.state.modal,
            event: this.state.modal === false ? {
                start: e.start,
                end: e.end,
            } : null,
            categories: this.state.categories
        });
    };

    render() {


        const events = [];
        const {lectures, categories} = {...this.state};

        if(this.state.lectures && this.state.categories) {

            lectures.forEach(l => {
                let start = new Date(l.start);
                let end = new Date(l.start);
                end.setHours(start.getHours()+2);

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
                                newStyle.backgroundColor = CategoryColors.find(c => c.category === event.category).color;
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
                    {this.state.modal !== false ?
                        <EventModal modal={this.state.modal}
                                    toggle={this.toggle}
                                    event={this.state.event}
                                    categories={this.state.categories}/>
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