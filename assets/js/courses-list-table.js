import React from 'react';
import ReactDOM from 'react-dom';

class Courses_List_Table extends React.Component {

    constructor() {
        super();
        this.state = {
            courses: []
        }
    }

    componentDidMount() {
        fetch('/api/course/show')
            .then(response => response.json())
            .then(entries => {
                this.setState({
                    courses: entries
                })
            })
    }

    render() {

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
        return (
            <table className="table">
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
            </table>

        )
    }
}

ReactDOM.render(<Courses_List_Table/>, document.getElementById('courses-list-table'));


