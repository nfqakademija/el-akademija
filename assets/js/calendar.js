import React from 'react';
import BigCalendar from 'react-big-calendar';
import moment from 'moment';
import 'moment/locale/lt';
import ReactDOM from "react-dom";

BigCalendar.momentLocalizer(moment);

class Calendar extends React.Component {

    constructor(props) {
        super(props);
    }


    render() {
        let events = [
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
        ];
        return(

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
                            backgroundColor: "green",
                            color: 'white',
                        };

                        if(event.category === 'PHP') {
                            newStyle.backgroundColor = "blue";
                        } else if(event.category === 'Front') {
                            newStyle.backgroundColor = "red";
                        }
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
            />
        )
    }
}

ReactDOM.render(<Calendar/>, document.getElementById('calendar'));