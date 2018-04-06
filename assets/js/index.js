import React from 'react';
import ReactDOM from 'react-dom';

class App extends React.Component {

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
            this.setState( {
                courses: entries
            })
        });
    }

    render() {

      const coursesList = this.state.courses.map(course => {
        return ( 
        <tr>
          <th scope="row">{course['id']}</th>
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

ReactDOM.render(<App/>, document.getElementById('root'));


