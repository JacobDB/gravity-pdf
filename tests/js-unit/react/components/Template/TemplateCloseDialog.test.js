import React from 'react'
import { shallow } from 'enzyme'
import { findByTestAttr } from '../../testUtils'
import { TemplateCloseDialog } from '../../../../../src/assets/js/react/components/Template/TemplateCloseDialog'

describe('Template - TemplateCloseDialog.js', () => {

  const historyMock = { push: jest.fn() }

  describe('Component functions', () => {

    const wrapper = shallow(<TemplateCloseDialog history={historyMock} />)
    const instance = wrapper.instance()

    test('handleKeyPress() - Check if Escape key pressed and current event target isn\'t our search box or the search box is blank already', () => {
      const e = { keyCode: 27, target: { className: '', value: '' } }
      instance.handleKeyPress(e)

      expect(historyMock.push.mock.calls.length).toBe(1)
    })

    test('handleCloseDialog() - trigger router', () => {
      instance.handleCloseDialog()

      expect(historyMock.push.mock.calls.length).toBe(1)
    })
  })

  describe('Run Lifecycle methods', () => {

    test('componentDidMount() - Assign keydown listener to document on mount', () => {
      const map = {}
      document.addEventListener = jest.fn((event, cb) => {
        map[event] = cb
      })
      const wrapper = shallow(<TemplateCloseDialog history={historyMock} />)
      const instance = wrapper.instance()
      const handleKeyPress = jest.spyOn(wrapper.instance(), 'handleKeyPress')
      instance.componentDidMount()
      // simulate event
      map.keydown({ key: 'Escape', keyCode: 27, target: { className: '', value: '' } })

      expect(handleKeyPress).toHaveBeenCalledTimes(1)
      expect(historyMock.push.mock.calls.length).toBe(1)
    })

    test('componentWillUnmount() - Remove keydown listener to document on mount', () => {
      const map = {}
      document.removeEventListener = jest.fn((event, cb) => {
        map[event] = cb
      })
      const wrapper = shallow(<TemplateCloseDialog history={historyMock} />)
      const instance = wrapper.instance()
      const handleKeyPress = jest.spyOn(wrapper.instance(), 'handleKeyPress')
      instance.componentWillUnmount()
      // simulate event
      map.keydown({ key: 'Escape', keyCode: 27, target: { className: '', value: '' } })

      expect(handleKeyPress).toHaveBeenCalledTimes(1)
      expect(historyMock.push.mock.calls.length).toBe(1)
    })
  })

  test('renders <TemplateCloseDialog /> component', () => {
    const wrapper = shallow(<TemplateCloseDialog />)
    const component = findByTestAttr(wrapper, 'component-templateCloseDialog')

    expect(component.length).toBe(1)
  })

  test('renders button screen reader text', () => {
    const wrapper = shallow(<TemplateCloseDialog />)

    expect(wrapper.find('span').text()).toBe('Close dialog')
  })

  test('check button click', () => {
    const wrapper = shallow(<TemplateCloseDialog history={historyMock} />)
    wrapper.simulate('click')

    expect(historyMock.push.mock.calls.length).toBe(1)
  })

  test('check button keyPress', () => {
    const wrapper = shallow(<TemplateCloseDialog history={historyMock} />)
    wrapper.simulate('keydown', { keyCode: 27, target: { className: '', value: '' } })

    expect(historyMock.push.mock.calls.length).toBe(1)
  })
})
