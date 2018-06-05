const api = {
    comment: {
        new: '/api/comment/new'
    },
    question: {
        show: '/api/question/show',
        comments: (id) => `/api/question/${id}/comments`,
        post_comment: '/api/comment/new',
        search: `/api/question/search`,
        new: '/api/question/new'
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
    },
    auth: {
        login: '/api/auth/login'
    },
};

module.exports = {
    api
};