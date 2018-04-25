import React from 'react';
import ReactDOM from 'react-dom';
import ApiClient from './api-client'

class Courses_List_Table extends React.Component {

    constructor() {
        super();
        this.state = {
            courses: null
        }
    }

    componentDidMount() {
        ApiClient.get('/api/course/show').then(courses => {
                this.setState({
                    courses: courses.data
                })
            }
        );

    }

    render() {

        if(!this.state.courses) {
            return <div></div>;
        } else {
            const coursesList = this.state.courses.map(course => {
                return (
                    <tr key={course['id']}>
                        <td scope="row">{course['id']}</td>
                        <td>{course['name']}</td>
                        <td>{course['start']}</td>
                        <td>{course['end']}</td>
                    </tr>
                )
            });


            let today = new Date();
            const currentCourse = this.state.courses.find(course => {
                    let startdate = new Date(course.start);
                    let enddate = new Date(course.end);
                    return course.name === "Kaunas | Pavasario semestras 2018" && startdate < today && enddate > today;
                }
            );
            return (
                /*<table className="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Start</th>
                        <th scope="col">End</th>
                    </tr>
                    </thead>
                    <tbody>
                    {coursesList}
                    </tbody>
                </table>*/
                <h6 className="currentCourse">{currentCourse.name}</h6>


            )
        }
    }
}

ReactDOM.render(<Courses_List_Table/>, document.getElementById('courses-list-table'));



