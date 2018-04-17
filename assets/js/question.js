import React from 'react';


import TimeAgo from 'javascript-time-ago';
import lt from 'javascript-time-ago/locale/lt';

TimeAgo.locale(lt);
const timeAgo = new TimeAgo('lt-LT');


class Question extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {

        // Kai dar neuzkrauta informacija
        if (!this.props.question) {
            return <div></div>
        } else {

            const {question} = {...this.props};
            const { user } = {...question};
            return (
                <div>

                    <div className="stream-post">
                        <div className="sp-author">
                            <a href="#" className="sp-author-avatar">
                                <img src="http://bootdey.com/img/Content/avatar/avatar6.png" alt=""/>
                            </a>
                            <h6 className="sp-author-name"><a href="#">{user.firstname} {user.lastname}</a></h6>
                            <div className="likes">
                                <div className="hearts">
                                    <span className="heart"></span>
                                    <span className="heart-number">TODO</span>
                                </div>
                                <div className="comments">
                                    <span className="comment"></span>
                                    <span className="comment-number">TODO</span>
                                </div>
                            </div>
                        </div>

                        <div className="sp-content">
                            <div className="sp-header">
                                <div className="sp-title">
                                    <a href={"/questions/"+question.id}> {question.title} </a>
                                </div>
                                <div className="sp-date">{timeAgo.format(Date.parse(question.created), 'twitter')}</div>
                            </div>
                            <p className="sp-paragraph mt-4">{question.text}</p>
                        </div>

                        <div className="button-blue mt-2 justify-content-end">
                            <a href={"/questions/"+question.id} className="btn button-shaped" role="button">Skaityti daugiau</a>
                        </div>
                    </div>
                </div>
            )

        }
    }
}

export default Question;


















