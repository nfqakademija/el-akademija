import React from 'react';
import BigCalendar from 'react-big-calendar';
import moment from 'moment';
import 'moment/locale/lt';
import ReactDOM from "react-dom";
import ApiClient from "./api-client";
const {api} = require('./api');
import { Button, Popover, PopoverHeader, PopoverBody } from 'reactstrap';

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

class Schedule extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            lectures: null
        }
    }

    componentDidMount() {
        ApiClient.get(api.lecture.show)
            .then(lectures => {
                this.setState({
                    lectures: lectures.data
                })
            });
    }

    render() {
            const events = [];
            const {lectures} = {...this.state};
            if(this.state.lectures) {

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
            }
            return(
                <div>
                    <BigCalendar
                        culture='lt'
                        popup events={events}
                        step={60}
                        showMultiDayTimes
                        defaultDate={new Date()}
                        views={["month", "week", "day"]}

                        eventPropGetter={
                            (event, start, end, isSelected) => {
                                let newStyle = {
                                    backgroundColor: event.category.color,
                                    color: 'white',
                                };
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
                                'day': 'diena',
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
                    />
                </div>

            )
    }
}

ReactDOM.render(<Schedule/>, document.getElementById('schedule'));