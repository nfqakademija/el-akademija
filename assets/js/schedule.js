import React from 'react';
import BigCalendar from 'react-big-calendar';
import moment from 'moment';
import 'moment/locale/lt';
import ReactDOM from "react-dom";
import ApiClient from "./api-client";
const {api} = require('./api');
import { Button, Popover, PopoverHeader, PopoverBody } from 'reactstrap';

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

        /*const events = [
            {
                id: 0,
                title: 'All Day Event very long title',
                allDay: true,
                start: new Date(2015, 3, 0),
                end: new Date(2015, 3, 1),
            },
            {
                id: 1,
                title: 'Long Event',
                start: new Date(2015, 3, 7),
                end: new Date(2015, 3, 10),
            },

            {
                id: 2,
                title: 'DTS STARTS',
                start: new Date(2016, 2, 13, 0, 0, 0),
                end: new Date(2016, 2, 20, 0, 0, 0),
            },

            {
                id: 3,
                title: 'DTS ENDS',
                start: new Date(2016, 10, 6, 0, 0, 0),
                end: new Date(2016, 10, 13, 0, 0, 0),
            },

            {
                id: 4,
                title: 'Some Event',
                start: new Date(2015, 3, 9, 0, 0, 0),
                end: new Date(2015, 3, 9, 0, 0, 0),
            },
            {
                id: 5,
                title: 'Conference',
                start: new Date(2015, 3, 11),
                end: new Date(2015, 3, 13),
                desc: 'Big conference for important people',
            },
            {
                id: 6,
                title: 'Meeting',
                start: new Date(2015, 3, 12, 10, 30, 0, 0),
                end: new Date(2015, 3, 12, 12, 30, 0, 0),
                desc: 'Pre-meeting meeting, to prepare for the meeting',
            },
            {
                id: 7,
                title: 'Lunch',
                start: new Date(2015, 3, 12, 12, 0, 0, 0),
                end: new Date(2015, 3, 12, 13, 0, 0, 0),
                desc: 'Power lunch',
            },
            {
                id: 8,
                title: 'Meeting',
                start: new Date(2015, 3, 12, 14, 0, 0, 0),
                end: new Date(2015, 3, 12, 15, 0, 0, 0),
            },
            {
                id: 9,
                title: 'Happy Hour',
                start: new Date(2015, 3, 12, 17, 0, 0, 0),
                end: new Date(2015, 3, 12, 17, 30, 0, 0),
                desc: 'Most important meal of the day',
            },
            {
                id: 10,
                title: 'Dinner',
                start: new Date(2015, 3, 12, 20, 0, 0, 0),
                end: new Date(2015, 3, 12, 21, 0, 0, 0),
            },
            {
                id: 11,
                title: 'Birthday Party',
                start: new Date(2015, 3, 13, 7, 0, 0),
                end: new Date(2015, 3, 13, 10, 30, 0),
            },
            {
                id: 12,
                title: 'Late Night Event',
                start: new Date(2015, 3, 17, 19, 30, 0),
                end: new Date(2015, 3, 18, 2, 0, 0),
            },
            {
                id: 13,
                title: 'Multi-day Event',
                start: new Date(2015, 3, 20, 19, 30, 0),
                end: new Date(2015, 3, 22, 2, 0, 0),
            },
            {
                id: 14,
                title: 'PHP',
                start: new Date(new Date().setHours(18,0)),
                end: new Date(new Date().setHours(20,0)),
                category: 'PHP'
            },
            {
                id: 15,
                title: 'Front',
                start: new Date(new Date().setHours(new Date().getHours() + 3)),
                end: new Date(new Date().setHours(new Date().getHours() + 6)),
                category: 'Front'
            },
        ];*/
            const events = [];
            const {lectures} = {...this.state};
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
                    />
                </div>

            )
    }
}

ReactDOM.render(<Schedule/>, document.getElementById('schedule'));