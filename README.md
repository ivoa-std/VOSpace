# VOSpace
[![PDF-Preview](https://img.shields.io/badge/Preview-PDF-blue)](../../releases/download/auto-pdf-preview/VOSpace-draft.pdf)



![VOSpace version](https://img.shields.io/badge/VOSpace-REC--2.1-yellow)


# VOSpace

## What is it?

VOSpace

VOSpace is the  [IVOA](http://www.ivoa.net/)interface to distributed storage.
It specifies how VO agents and applications can use network attached data
stores to persist and exchange data in a standard way.

A VOSpace web service is an access point for a distributed storage network.
Through this access point, a client can:

1. add or delete data objects in a tree data structure;

2. manipulate metadata for the data objects

3. obtain URIs through which the content of the data objects can be accessed

VOSpace does not define how the data is stored or transferred, only the
control messages to gain access.
Thus, the VOSpace interface can readily be added to an existing storage system.

When we speak of "a VOSpace", we mean the arrangement of data accessible
through one particular VOSpace service.

Each data object within a VOSpace service is represented as a node and has
a description called a representation.
A useful analogy to have in mind when reading this document
is that a node is equivalent to a file or a directory.


## Status?

The last stable version is
**[REC-2.1](http://www.ivoa.net/documents/VOSpace/20180620/index.html)**.

See also the section
[Releases](https://github.com/ivoa-std/VOSpace/releases)
of this GitHub Repository.

## What about this repository?

This GitHub repository contains the sources of the IVOA document describing
 VOSpace.

Only the LaTeX version is available here. No output version (e.g. PDF, HTML,
DOC) should be stored in this repository.


## Want to contribute?

1. [Raise a GitHub Issue](https://github.com/ivoa-std/VOSpace/issues/new) on this
   repository

2. Fork this repository _(eventually clone it on your machine if you want to)_

3. Create a branch in your forked repository ; this branch should be named after the issue(s) to fix (for instance: `issue-7-add-license`)

4. Commit suggested changes inside this branch

5. Create a Pull Request on the official repository _(note: a `git push` is needed first, if you are working on a clone)_

6. Wait for someone to review your Pull Request and accept it

_This process has been described and demonstrated during the IVOA Interoperability Meeting of Oct. 2019 in Groningen ; see [slides](https://wiki.ivoa.net/internal/IVOA/InterOpOct2019GitHub/IVOA_Github.pdf))_

## License

[![Creative Commons License](https://i.creativecommons.org/l/by-sa/4.0/88x31.png)](http://creativecommons.org/licenses/by-sa/4.0/)
This work is licensed under a
[Creative Commons Attribution-ShareAlike 4.0 International License](http://creativecommons.org/licenses/by-sa/4.0/).
