import React from 'react'
import Api from '../utils/api'
import Style from 'react-postcss'
import Glyph from 'elemental/lib/components/Glyph'

import postcssPlugins from '../postcss-plugins'

import Header from '../components/partials/header'
import TagManager from '../components/tag-manager'

export default React.createClass({

    getInitialState: function () {
        return {
            description: '',
            url: '',
            tags: []
        }
    },

    componentDidMount: function () {
        Api.getRepository(this.props.data.id, this._setData);
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    _onTagAdd: function (title) {
        Api.addTag({
            repository_id: this.state.id,
            title: title
        }, this._onStateTagAdd);
    },

    _onStateTagAdd: function (response) {
        var newState = this.state;
        newState.tags.push(response[0]);
        this.setState(newState);
    },

    _onTagClear: function (id) {
        Api.removeTag({
            '_method': 'DELETE',
            'repository_id': this.state.id,
            'tag_id': id
        }, this._onStateTagRemove);
    },

    _onStateTagRemove: function (response) {
        var i, tag, newState = this.state;

        for (i in this.state.tags) {
            if (this.state.tags.hasOwnProperty(i)) {
                tag = this.state.tags[i];
                if (tag.id === parseInt(response.id)) {
                    newState.tags.splice(i, 1);
                    this.setState(newState);
                }
            }
        }
    },

    _onTagClick: function (id) {
        window.location.hash = '/tags/' + id;
    },

    style: function () {
        return `
            .page-repository {
                max-width: 1200px;
                margin: auto;
                padding-top: 50px;

                &__body {
                    display: flex;
                    flex-direction: row;
                }

                &__content {
                    width: 75%
                }

                &__title {
                    display: flex;
                    flex-direction: row;

                    margin: 0 0 10px 0;

                    h1 {
                        margin: 0;
                    }
                }

                &__tags {
                    width: 25%;
                    padding: 10px;
                    border: 1px solid #f1f1f1;
                    border-radius: 4px;
                    background: #f5f5f5;
                }

                &__github-link {
                    margin-right: 10px;
                    line-height: 42px;

                    .octicon {
                        color: #000011;
                        font-size: 42px;
                    }
                }

            }
        `
    },

    render: function () {
        return (
            <div className="page-repository">
                <Style plugins={postcssPlugins}>
                    {this.style()}
                </Style>
                <Header />
                <div className="page-repository__body">
                    <div className="page-repository__content">
                        <div className="page-repository__title">
                            <a className="page-repository__github-link" href={this.state.url}><Glyph icon="mark-github"
                                                                                                     target="_blank"/></a>
                            <h1>{this.state.name}</h1>
                        </div>
                        <div className="page-repository__description">
                            <p>{this.state.description}</p>
                        </div>
                    </div>
                    <div className="page-repository__tags">
                        <TagManager tags={this.state.tags} onTagClick={this._onTagClick} onTagAdd={this._onTagAdd}
                                    onTagClear={this._onTagClear}/>
                    </div>
                </div>
            </div>
        )
    }

});
