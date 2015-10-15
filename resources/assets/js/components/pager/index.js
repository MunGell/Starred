import React from 'react'
import Style from 'react-postcss'
import Glyph from 'elemental/lib/components/Glyph'
import postcssPlugins from '../../postcss-plugins'

export default React.createClass({

    _renderButtons: function () {
        let buttons = [];
            if (this.props.disabled !== 'prev') {
                buttons.push(<button className="component-pager__button" onClick={this.props.onClickPrev}><Glyph icon="chevron-left"/> Previous</button>);
            }
            if (this.props.disabled !== 'next') {
                buttons.push(<button className="component-pager__button" onClick={this.props.onClickNext}>Next <Glyph icon="chevron-right"/></button>);
            }
        return buttons;
    },

    style: function() {
        return `
            .component-pager {
                &__button {
                    background: none;
                    border: 1px solid rgba(0, 0, 0, 0.1);
                    border-radius: 3px;
                    color: #666;
                    cursor: pointer;
                    padding: 5px 10px;

                    &:first-child {
                        margin-right: 5px;
                    }

                    &:last-child {
                        margin-left: 5px;
                    }

                    &:hover,
                    &:focus {
                        background-color: rgba(0, 0, 0, 0.05);
                        border-color: rgba(0, 0, 0, 0.05);
                        outline: none;
                    }
                }
            }
        `
    },

    render: function () {
        return (
            <div className="component-pager">
                <Style plugins={postcssPlugins}>
                    {this.style()}
                </Style>
                {this._renderButtons()}
            </div>
        )
    }
});
