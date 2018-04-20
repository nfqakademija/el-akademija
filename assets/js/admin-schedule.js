import React from 'react';
import BigCalendar from 'react-big-calendar';
import moment from 'moment';
import 'moment/locale/lt';
import ReactDOM from "react-dom";
import ApiClient from "./api-client";
const {api} = require('./api');
import { Popover, PopoverHeader, PopoverBody,
    Button, Modal, ModalHeader, ModalBody, ModalFooter
} from 'reactstrap';

BigCalendar.momentLocalizer(moment);

const CategoryColors = [
    {category:'Backend', color:'blue'},
    {category:'Frontend', color:'green'},
    {category:'Mysql', color:'yellow'},
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

class AdminSchedule extends React.Component {


    constructor(props) {
        super(props);
        this.state = {
            lectures: null,
            modal: false
        }
        this.toggle = this.toggle.bind(this);
    }

    componentDidMount() {
        ApiClient.get(api.lecture.show)
            .then(lectures => {
                this.setState({
                    lectures: lectures.data
                })
            });
    }

    toggle = (e) => {
        console.log(e);
        this.setState({
            modal: !this.state.modal
        });
    }

    render() {


        const events = [];
        const {lectures} = {...this.state};

        const EventModal = props => (
            <div>
                <Modal isOpen={this.state.modal} fade={true} toggle={this.toggle}>
                    <ModalHeader toggle={this.toggle}>Paskaitos pridėjimas</ModalHeader>
                    <ModalBody>

                    </ModalBody>
                    <ModalFooter>
                        <Button color="primary" onClick={this.toggle}>Do Something</Button>
                        <Button color="secondary" onClick={this.toggle}>Cancel</Button>
                    </ModalFooter>
                </Modal>
            </div>
        );


        if(this.state.lectures) {

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
        }
        return(
            <div>
                <BigCalendar
                    selectable
                    culture='lt'
                    popup events={events}
                    step={60}
                    showMultiDayTimes
                    defaultDate={new Date()}
                    views={{ month: true, week: true, day: true }}

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
                            'today': 'šiandien',
                            'previous': 'atgal',
                            'next': 'kitas',
                            'month': 'mėnuo',
                            'week': 'savaitė',
                            'day': 'diena'
                        }
                    }
                    components={{
                        event: CustomEvent,
                    }}
                    onSelectSlot={s => this.toggle(s)}
                />
                <EventModal/>
            </div>

        )
    }
}

ReactDOM.render(<AdminSchedule/>, document.getElementById('admin-schedule'));