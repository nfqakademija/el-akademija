const api = {
    comment: {
        new: '/api/comment/new'
    },
    question: {
        show: '/api/question/show',
        comments: (id) => `/api/question/${id}/comments`,
        post_comment: '/api/comment/new',
    },
    lecture: {
        show: '/api/lecture/show'
    },
    category: {
        show: '/api/category/show'
    }
};

module.exports = {
    api
}