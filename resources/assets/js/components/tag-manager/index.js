import React from 'react'
import Style from 'react-postcss'
import postcssPlugins from '../../postcss-plugins'

import Form from './form'
import TagList from './tag-list'

export default React.createClass({

    getDefaultProps: function () {
        return {
            tags: [],
            onTagClick: function() {},
            onTagAdd: function() {},
            onTagClear: function() {}
        }
    },

    style: function() {
        return `
            .component-tag-manager {
                &__input {
                    width: 100%;
                    padding: 5px;
                }

                &__list {
                    padding: 0;
                    margin: 10px 0 0 0;
                }

                .Pill {
                    &__label {
                        margin-right: 0;
                    }
                    &__clear {
                        margin-left: 0;
                        border-left: 1px solid #585858;
                    }
                }
            }
        `
    },

    render: function () {
        return (
            <div className="component-tag-manager">
                <Style plugins={postcssPlugins}>
                    {this.style()}
                </Style>
                <Form onTagAdd={this.props.onTagAdd} />
                <TagList tags={this.props.tags} onTagClick={this.props.onTagClick} onTagClear={this.props.onTagClear} />
            </div>
        )
    }
});
