import React from 'react';
import BigCalendar from 'react-big-calendar';
import moment from 'moment';
import 'moment/locale/lt';
import ReactDOM from "react-dom";
import ApiClient from "./api-client";
const {api} = require('./api');
import {
    Popover, PopoverHeader, PopoverBody,
    Container, Row, Col,
} from 'reactstrap';

BigCalendar.momentLocalizer(moment);

class EventPopover extends React.Component {
    constructor(props) {
        super(props);

        this.toggle = this.toggle.bind(this);
        this.state = {
            popoverOpen: false,
        };
    }

    toggle() {
        this.setState({
            popoverOpen: !this.state.popoverOpen
        });
    }

    render() {
        return (
            <Popover placement={this.props.placement} isOpen={this.props.isOpen} target={`Event${this.props.event.id}`}
                     toggle={this.props.toggle}>
                <PopoverHeader style={{
                    backgroundColor: this.props.event.category.color,
                    color: 'white'
                }}>{this.props.event.title}</PopoverHeader>
                <PopoverBody>
                    <Container>
                        <Row>
                            <Col sm={6} className="mr-0" style={{whiteSpace: "nowrap"}}>
                                <p className="font-weight-bold mb-0" style={{fontSize: "1.1em"}}>
                                    Lektorius
                                </p>
                                <p className="small">
                                    {this.props.event.lector.firstname + ' ' + this.props.event.lector.lastname}
                                </p>
                            </Col>
                            <Col sm={6}>
                                <p className="font-weight-bold mb-0" style={{fontSize: "1.1em"}}>
                                    Kategorija
                                </p>
                                <p className="small">
                                    {this.props.event.category.name}
                                </p>
                            </Col>
                        </Row>
                        <Row>
                            <Col sm={12} className="mr-0">
                                <p className="font-weight-bold mb-0 text-center" style={{fontSize: "1.2em"}}>
                                    Aprašymas
                                </p>
                                <p className="small" dangerouslySetInnerHTML={{__html: this.props.event.description}}/>
                            </Col>
                        </Row>
                    </Container>
                </PopoverBody>
            </Popover>
        );
    }

}

class CustomMonthEvent extends React.Component {
    constructor(props) {
        super(props);

        this.toggle = this.toggle.bind(this);
        this.state = {
            popoverOpen: false,
        };


    }

    toggle() {
        this.setState({
            popoverOpen: !this.state.popoverOpen
        });
    }

    render() {
        return (
            <div id={`Event${this.props.event.id}`} onClick={this.toggle} style={{cursor: 'pointer'}}>
                <div className="d-flex justify-content-between">
                    <div className="p-0">{this.props.event.title}</div>
                    <div
                        className="p-0">{moment(this.props.event.start).format("HH:mm")} - {moment(this.props.event.end).format("HH:mm")}</div>
                </div>
                <EventPopover
                    placement="left"
                    isOpen={this.state.popoverOpen}
                    event={this.props.event}
                    toggle={this.toggle}
                />
            </div>
        );
    }
}

class CustomWeekEvent extends React.Component {
    constructor(props) {
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

    render() {
        return (
            <div id={`Event${this.props.event.id}`} onClick={this.toggle} style={{cursor: 'pointer', height: "100%"}}>
                {this.props.event.title}
                <EventPopover
                    placement="left"
                    isOpen={this.state.popoverOpen}
                    event={this.props.event}
                    toggle={this.toggle}
                />
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