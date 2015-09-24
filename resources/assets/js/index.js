import $ from 'jquery'
import React from 'react'
import RoutePattern from 'route-pattern'

import LandingPage from './pages/LandingPage'
import RepositoriesPage from './pages/RepositoriesPage'
import RepositoryPage from './pages/RepositoryPage'
import SearchPage from './pages/SearchPage'
import TagPage from './pages/TagPage'

var Routes = {
    '*': LandingPage,
    'search': SearchPage,
    'search/?page=:page': SearchPage,
    'repositories': RepositoriesPage,
    'repositories/?page=:page': RepositoriesPage,
    'repositories/:id': RepositoryPage,
    'tags/:id': TagPage
};

var App = React.createClass({

    getInitialState: function () {
        return {
            route: this._getRoute(),
            component: this._getComponent()
        };
    },

    componentWillMount: function () {
        window.addEventListener('hashchange', this._onHashChange);
    },

    _onHashChange: function () {
        this.setState({
            route: this._getRoute(),
            component: this._getComponent()
        });
    },

    _getRoute: function () {
        return window.location.hash.substr(2);
    },

    _getComponent: function () {
        var route = this._getRoute(),
            component = null,
            routeData = null;

        for (var r in Routes) {
            routeData = RoutePattern.fromString(r).match(route);
            if (routeData !== null) {
                component = {
                    component: Routes[r],
                    data: routeData.namedParams
                };
            }
        }

        return component;
    },

    render: function () {
        var Component = this.state.component.component;
        return (
            <Component data={this.state.component.data}/>
        )
    }
});

React.render(
    <App />,
    $('#app').get(0)
);