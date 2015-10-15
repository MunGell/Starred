import React from 'react'
import Style from 'react-postcss'
import postcssPlugins from '../../postcss-plugins'

export default React.createClass({

    getDefaultProps: function () {
        return {
            data: []
        }
    },

    style: function() {
        return `
        .component-tag-list {
            &__list {
                padding: 0;
                list-style: none;

                &__item {
                    margin-bottom: 10px;
                    padding: 10px;
                    border: 1px solid #f1f1f1;
                    border-radius: 4px;
                    background: #f5f5f5;
                }
            }
        }
        `
    },

    render: function () {
        return (
            <div className="component-tag-list">
                <Style plugins={postcssPlugins}>
                    {this.style()}
                </Style>
                <ul className="component-tag-list__list">
                {this.props.data.map(function (value) {
                    return (
                        <li className="component-tag-list__list__item" key={value.id}>
                            <a href={'#' + this.props.root + value.id}>{value.title}</a>
                        </li>
                    )
                }.bind(this))}
                </ul>
            </div>
        )
    }
});
