import React from 'react';


import TimeAgo from 'javascript-time-ago';
import lt from 'javascript-time-ago/locale/lt';

TimeAgo.locale(lt);
const timeAgo = new TimeAgo('lt-LT');


class Comment extends React.Component {

    constructor(props) {
        super(props);
    }


    render() {
        if(!this.props.comment) {
            return <div>Loading...</div>
        } else {
            let {comment} = this.props;
            let {user} = comment;
            return (
                <div>
                    <div className="stream-posts">
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
                                <div className="sp-header justify-content-end">
                                    <div className="sp-date">{timeAgo.format(Date.parse(comment.created), 'twitter')}</div>
                                </div>
                                <p className="sp-paragraph mt-4">{comment.text}</p>
                            </div>
                        </div>
                    </div>
                </div>
            )

        }
    }
}
export default Comment;