const api = {
    comment: {
        new: '/api/comment/new'
    },
    question: {
        show: '/api/question/show',
        comments: (id) => `/api/question/${id}/comments`,
        post_comment: '/api/comment/new',
    }
};

module.exports = {
    api
}