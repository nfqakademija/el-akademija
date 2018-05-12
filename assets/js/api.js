const api = {
    comment: {
        new: '/api/comment/new'
    },
    question: {
        show: '/api/question/show',
        comments: (id) => `/api/question/${id}/comments`,
        post_comment: '/api/comment/new',
        search: `/api/question/search`
    },
    lecture: {
        show: '/api/lecture/show',
        new: '/api/lecture/new'
    },
    category: {
        show: '/api/category/show'
    },
    course: {
        show: '/api/course/show'
    },
    user: {
        show: '/api/user/show'
    }
};

module.exports = {
    api
}