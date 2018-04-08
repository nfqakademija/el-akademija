import React from 'react';
import Comment from './comment';

class CommentsList extends React.Component {

    constructor(props) {
        super(props);
    }


    render() {
        if(!this.props.comments) {
            return <div>Loading...</div>
        } else {
            let {comments} = this.props;
            return (
                <div className="container mx-3">
                    {comments.map(comment =>
                        <Comment key={comment.id} comment={comment} />
                    )}
                </div>
            )

        }
    }
}
export default CommentsList;