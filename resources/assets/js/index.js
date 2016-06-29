import $ from 'jquery'
import React from 'react'
import ReactDOM from 'react-dom'
import {Router, RoutableMixin} from 'react-lighthouse'

import LandingPage from './pages/LandingPage'
import RepositoriesPage from './pages/RepositoriesPage'
import RepositoryPage from './pages/RepositoryPage'
import SearchPage from './pages/SearchPage'
import TagPage from './pages/TagPage'

var routes = {
    'tags/:id': TagPage,
    'repositories/:id': RepositoryPage,
    'repositories/?page=:page': RepositoriesPage,
    'repositories': RepositoriesPage,
    'search/?page=:page': SearchPage,
    'search': SearchPage,
    '*': LandingPage
};

var App = React.createClass({
    mixins: [
        RoutableMixin
    ],

    render: function () {
        return Router(routes, this.state.route, this.state);
    }
});

ReactDOM.render(
    <App />,
    $('#app').get(0)
);
