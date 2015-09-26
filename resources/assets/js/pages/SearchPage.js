import React from 'react'
import Api from '../utils/api'

import Header from '../components/partials/header'
import RepositoryList from '../components/repository-list'
import TagList from '../components/tag-list'
import Pager from '../components/pager'

export default React.createClass({

    getInitialState: function () {
        return {
            tags: [],
            repositories: {
                current_page: 0,
                from: 0,
                to: 0,
                per_page: 0
            }
        }
    },

    _callApi: function (page) {
        page = page || this.props.data.page;
        Api.search(this.refs.searchField.getDOMNode().value, page, this._setData);
    },

    _onSearchChange: function () {
        var keyword = this.refs.searchField.getDOMNode().value;
        if (keyword.length > 1) {
            this._callApi();
        }
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    _onPagerClickNext: function() {
        this._callApi(this.state.repositories.current_page + 1);
    },

    _onPagerClickPrev: function() {
        this._callApi(this.state.repositories.current_page - 1);
    },

    _renderPager: function() {
        let repos = this.state.repositories;
        let pagerDisabled = repos.current_page === repos.from ? 'prev' : repos.current_page === repos.to ? 'next' :  null;
        return repos.current_page > 0 ? <Pager onClickNext={this._onPagerClickNext} onClickPrev={this._onPagerClickPrev}
                                                    disabled={pagerDisabled}/> : null;
    },

    render: function () {

        return (
            <div className="page-search">
                <Header />
                <div className="page-search__search-field">
                    <input className="page-search__search-field__input" type="text" placeholder="Search" ref="searchField" onChange={this._onSearchChange} />
                </div>
                <div className="page-search__results">
                    <div className="page-search__results__repositories">
                        <RepositoryList data={this.state.repositories.data} root='/repositories/' />
                    </div>
                    <div className="page-search__results__tags">
                        <TagList data={this.state.tags} root='/tags/' />
                    </div>
                </div>
                <div className="page-search__paginator">
                    {this._renderPager()}
                </div>
            </div>
        )
    }

});
