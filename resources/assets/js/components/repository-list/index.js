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
            .component-repository-list {
                &__list {
                    padding: 0;
                    list-style: none;

                    &__item {
                        margin-bottom: 10px;
                        padding: 10px;
                        border: 1px solid #f1f1f1;
                        border-radius: 4px;
                        background: #f5f5f5;

                        &__link {

                        }

                        &__description {
                            margin: 0;
                        }
                    }
                }
            }
        `
    },

    render: function () {
        return (
            <div className="component-repository-list">
                <Style plugins={postcssPlugins}>
                    {this.style()}
                </Style>
                <ul className="component-repository-list__list">
                {this.props.data.map(function (value) {
                    return (
                        <li className="component-repository-list__list__item" key={value.id}>
                            <a className="component-repository-list__list__item__link" href={'#' + this.props.root + value.id}>{value.full_name}</a>
                            <p className="component-repository-list__list__item__description" >{value.description}</p>
                        </li>
                    )
                }.bind(this))}
                </ul>
            </div>
        )
    }
});
